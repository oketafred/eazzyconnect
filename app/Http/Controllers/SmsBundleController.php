<?php

namespace App\Http\Controllers;

use Exception;
use App\Rules\Phone;
use Inertia\Inertia;
use App\Models\SmsBundle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Client\RequestException;

class SmsBundleController extends Controller
{
    public function __construct(public PaymentService $paymentService)
    {
    }

    public function index()
    {
        return Inertia::render('SmsBundle/Index', [
            'accountBalance' => Number::currency(Auth::user()?->accountBalance(), 'UGX'),
            'smsBundles' => SmsBundle::query()
                ->orderByDesc('id')
                ->paginate(20)
                ->withQueryString()
                ->through(fn ($sms_bundle) => [
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

    /**
     * @throws RequestException
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'amount' => 'required',
            'phone_number' => ['required', new Phone()],
        ]);

        $user = Auth::user();

        try {
            $transaction_reference = $this->paymentService->generateReference();

            $sms_bundle = $request->user()->sms_bundle()->create([
                'currency_code' => 'UGX',
                'amount' => $validated['amount'],
                'customer_name' => $user?->name,
                'customer_email' => $user?->email,
                'phone_number' => $validated['phone_number'],
                'transaction_reference' => $transaction_reference,
                'transaction_fee' => ((2.5 / 100) * $validated['amount']),
                'transaction_percent' => 2.5,
                'additional_fee' => ((0.5 / 100) * $validated['amount']),
                'additional_percent' => 0.5,
            ]);

            $response = $this->paymentService->requestPayment([
                'account_no' => config('relworx.relworx_account_no'),
                'reference' => $sms_bundle->transaction_reference,
                'msisdn' => $sms_bundle->phone_number,
                'currency' => $sms_bundle->currency_code,
                'amount' => $sms_bundle->amount + $sms_bundle->transaction_fee + $sms_bundle->additional_fee,
            ]);

            $sms_bundle->update([
                'external_id' => $response['internal_reference'],
            ]);

            return response()->json($response, 201);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}
