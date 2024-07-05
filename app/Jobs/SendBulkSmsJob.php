<?php

namespace App\Jobs;

use Throwable;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Services\AfricasTalkingService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private AfricasTalkingService $smsService;

    public function __construct(
        private string $phoneNumber,
        private string $message,
        private User $user,
        private int $groupId,
        AfricasTalkingService $smsService
    ) {
        $this->smsService = $smsService;
    }

    public function handle(): void
    {
        try {
            $response = $this->sendSms();
            Log::info("SMS sent successfully", ['response' => $response]);
        } catch (Throwable $throwable) {
            Log::error("Error sending SMS: {$throwable->getMessage()}", ['exception' => $throwable]);
        }
    }

    /**
     * @throws RequestException
     */
    private function sendSms(): array
    {
        $response = $this->smsService->sendSms($this->phoneNumber, $this->message);
        $payload = $response['SMSMessageData']['Recipients'][0];

        $this->user->smses()->create([
            'group_id' => $this->groupId,
            'cost' => $this->calculateSmsCost(),
            'phone_number' => $payload['number'],
            'status' => $payload['status'],
            'messageId' => $payload['messageId'],
            'message' => $this->message,
        ]);

        return $response;
    }

    private function calculateSmsCost(): int
    {
        $numberOfSms = ceil(strlen($this->message) / Sms::MAX_NUMBER_OF_CHARACTERS_IN_AN_SMS);
        return (int)($numberOfSms * Sms::COST_PER_SMS);
    }
}
