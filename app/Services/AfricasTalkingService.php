<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class AfricasTalkingService
{
    private string $username;

    private string $apiKey;

    private string $baseUrl;

    public function __construct()
    {
        $this->username = config('africastalking.username');
        $this->apiKey = config('africastalking.apiKey');
        $this->baseUrl = 'https://api.africastalking.com';
    }

    /**
     * @throws RequestException
     */
    public function sendSms(string $to, string $message): mixed
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'apiKey' => $this->apiKey,
        ])->asForm()
            ->post($this->baseUrl.'/version1/messaging', [
                'username' => $this->username,
                'to' => $to,
                'message' => $message,
            ])->throw()
            ->json();
    }
}
