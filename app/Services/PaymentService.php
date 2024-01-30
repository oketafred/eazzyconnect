<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentService {

    private string $baseUrl;
    private string $accountNo;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('relworx.relworx_base_url');
        $this->accountNo = config('relworx.relworx_account_no');
        $this->apiKey = config('relworx.relworx_api_key');
    }

    /**
     *
     * @param array $data
     * @return array|mixed
     * @throws RequestException
     */
    public function requestPayment(array $data)
    {
        $headers = [
            "Content-Type" => "application/json",
            "Accept" => "application/vnd.relworx.v2",
            "Authorization" => "Bearer {$this->apiKey}"
        ];

        return Http::withHeaders($headers)
            ->post("{$this->baseUrl}/api/mobile-money/request-payment", $data)
            ->throw()
            ->json();
    }

    public function generateReference(): string
    {
        return  substr('RELWORX-' . Str::uuid(), 0, 30);
    }
}
