<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\SmsBundle;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSmsBundleRequest;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpFoundation\Response;

class SmsBundleController extends Controller
{
    private const TRANSACTION_FEE_PERCENTAGE = 0.25;
    private const ADDITIONAL_FEE_PERCENTAGE = 0.05;

    private PaymentService $paymentService;
    private $relworxAccountNo;

    public function __construct(PaymentService $paymentService, $relworxAccountNo = null)
    {
        $this->paymentService = $paymentService;
        $this->relworxAccountNo = $relworxAccountNo ?? config('relworx.relworx_account_no');
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
    public function store(StoreSmsBundleRequest $request)
    {
        $validated = $request->validated();
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
                'transaction_fee' => $this->calculateTransactionFee($validated['amount']),
                'transaction_percent' => self::TRANSACTION_FEE_PERCENTAGE,
                'additional_fee' => $this->calculateAdditionalFee($validated['amount']),
                'additional_percent' => self::ADDITIONAL_FEE_PERCENTAGE,
            ]);

            $response = $this->paymentService->requestPayment([
                'account_no' => $this->relworxAccountNo,
                'reference' => $sms_bundle->transaction_reference,
                'msisdn' => $sms_bundle->phone_number,
                'currency' => $sms_bundle->currency_code,
                'amount' => (float)$sms_bundle->amount + (float)$sms_bundle->transaction_fee + (float)$sms_bundle->additional_fee,
            ]);

            $sms_bundle->update([
                'external_id' => $response['internal_reference'],
            ]);

            return response()->json($response, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function calculateTransactionFee(float $amount): float
    {
        return self::TRANSACTION_FEE_PERCENTAGE * $amount;
    }

    private function calculateAdditionalFee(float $amount): float
    {
        return self::ADDITIONAL_FEE_PERCENTAGE * $amount;
    }
}
