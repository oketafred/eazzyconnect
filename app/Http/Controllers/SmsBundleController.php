<?php

namespace App\Http\Controllers;

use App\Models\SmsBundle;
use App\Rules\Phone;
use App\Services\FlutterwaveService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SmsBundleController extends Controller
{
    public function __construct(public FlutterwaveService $flutterwaveService)
    {
    }

    public function index()
    {
        return Inertia::render('SmsBundle/Index', [
            'accountBalance' => Number::currency(Auth::user()?->accountBalance(), 'UGX'),
            'flwPublicKey' => config('flutterwave.public_key'),
            'smsBundles' => SmsBundle::query()
                ->orderByDesc('id')
                ->paginate(20)
                ->withQueryString()
                ->through(fn($sms_bundle) => [
                    'id' => $sms_bundle->id,
                    'createdAt' => $sms_bundle->created_at->diffForHumans(),
                    'amount' => Number::format($sms_bundle->amount),
                    'status' => Str::of($sms_bundle->status)
                        ->contains(SmsBundle::STATUS_FAILED) ?
                        ucfirst(SmsBundle::STATUS_FAILED) :
                        ucfirst($sms_bundle->status),
                ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'amount' => 'required',
            'phone_number' => ['required', new Phone()]
        ]);

        $user = Auth::user();

        $sms_bundle = $request->user()->sms_bundle()->create([
            'amount' =>  $validated['amount'],
            'customer_name' =>  $user?->name,
            'customer_email' =>  $user?->email,
            'phone_number' =>  $validated['phone_number'],
            'transaction_reference' =>  Str::uuid(),
        ]);

        return response()->json($sms_bundle);
    }

    public function verifyTransaction(Request $request, $transaction_id)
    {
        try {
            $verificationData = $this->flutterwaveService->verifyTransaction($transaction_id);
            if ($verificationData['status'] === SmsBundle::STATUS_PENDING) {
                return response()->json([
                    'message' => 'Transaction is still pending'
                ], Response::HTTP_BAD_REQUEST);
            }

            $payload = $verificationData['data'];

            SmsBundle::query()
                ->where('transaction_reference', $payload['tx_ref'])
                ->where('amount', $payload['amount'])
                ->update([
                    'status' => $payload['status'],
                    'external_id' => $payload['id'],
                    'payment_type' => $payload['payment_type']
                ]);

            return response()->json([
                'message' => 'Transaction successful'
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::error($exception);
            return response()->json([
                'message' => 'Something went wrong. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
