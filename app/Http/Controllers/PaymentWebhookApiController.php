<?php

namespace App\Http\Controllers;

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
        if ($verified && $request->event === 'charge.completed' && $request->data['status'] === 'successful') {
            $verificationData = $this->flutterwaveService->verifyTransaction($request->data['id']);
            if ($verificationData['status'] === 'success') {
                // TODO: Update the transaction here

                return response()->json([
                    'message' => 'Transaction successful'
                ], Response::HTTP_OK);
            }
            // TODO: Update the transaction here

            return response()->json([
                'message' => 'Transaction failed'
            ], Response::HTTP_OK);
        }
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
