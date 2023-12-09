<?php

namespace App\Http\Controllers;

use App\Models\SmsBundle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\FlutterwaveService;
use Illuminate\Support\Facades\Log;

class PaymentWebhookApiController extends Controller
{
    private FlutterwaveService $flutterwaveService;

    public function __construct(FlutterwaveService $flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
    }

    public function webhook(Request $request)
    {
        $verified = $this->verifyWebhook();

        Log::info(json_encode($request));

        // if it is a charge event, verify and confirm it is a successful transaction
        if ($verified && $request->event === 'charge.completed') {
            $verificationData = $this->flutterwaveService->verifyTransaction($request->data['id']);
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
        }

        return response()->json([
            'message' => 'Transaction event is not charge.completed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function verifyWebhook(): bool
    {
        $secretHash = config('flutterwave.secret_hash');

        if (request()?->header('verif-hash')) {
            $requestSignature = request()?->header('verif-hash');
            if ($requestSignature === $secretHash) {
                return true;
            }
        }
        return false;
    }
}
