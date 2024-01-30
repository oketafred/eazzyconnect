<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SmsBundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PaymentWebhookApiController extends Controller
{
    public function webhook(Request $request)
    {
        try {
            $payload = $request->all();

            $smsBundle = SmsBundle::query()
                ->where('external_id', $payload['internal_reference'])
                ->where('transaction_reference', $payload['customer_reference'])
                ->where('amount', $payload['amount'])
                ->where('status', SmsBundle::STATUS_PENDING)
                ->where('phone_number', $payload['msisdn'])
                ->first();

            if (!$smsBundle) {
                throw new Exception('SmsBundle not found for payment webhook');
            }

            $smsBundle->status = $payload['status'];
            $smsBundle->payment_type = $payload['provider'];
            $smsBundle->transaction_fee = $payload['charge'];
            $smsBundle->save();

            return response()->json([
                'message' => 'Transaction successful'
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::error('Error in payment webhook: ' . $exception->getMessage());

            return response()->json([
                'message' => 'Error occurred transaction could not be completed!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
