<?php

namespace App\Http\Controllers;

use App\Models\SmsBundle;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaymentWebhookRequest;
use Symfony\Component\HttpFoundation\Response;

class PaymentWebhookApiController extends Controller
{
    public function webhook(PaymentWebhookRequest $request)
    {
        $payload = $request->validated();

        try {
            $smsBundle = $this->findSmsBundle($payload);
            $this->updateSmsBundle($smsBundle, $payload);

            return response()->json([
                'message' => 'Transaction successful'
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::error('Error in payment webhook: ' . $exception->getMessage());

            return response()->json([
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function findSmsBundle(array $payload)
    {
        return SmsBundle::query()
            ->where('external_id', $payload['internal_reference'])
            ->where('transaction_reference', $payload['customer_reference'])
            ->where('status', SmsBundle::STATUS_PENDING)
            ->where('phone_number', $payload['msisdn'])
            ->firstOrFail();
    }

    protected function updateSmsBundle(SmsBundle $smsBundle, array $payload): void
    {
        $smsBundle->update([
            'status' => $payload['status'],
            'payment_type' => $payload['provider'],
            'transaction_fee' => $payload['charge'],
        ]);
    }
}
