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

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $phone_number,
        public string $message,
        public User $user,
        public $group_id,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(AfricasTalkingService $africasTalkingService): void
    {
        try {
            $response = $africasTalkingService->sendSms(
                $this->phone_number,
                $this->message
            );

            $payload = $response['SMSMessageData']['Recipients'][0];

            $this->user->smses()->create([
                'group_id' => $this->group_id,
                'cost' => $this->calculateSmsCost(),
                'phone_number' => $payload['number'],
                'status' => $payload['status'],
                'messageId' => $payload['messageId'],
                'message' => $this->message,
            ]);

            Log::info(json_encode($response));
        } catch (Throwable $throwable) {
            Log::error($throwable);
        }
    }

    private function calculateSmsCost(): int
    {
        $numberOfSms = ceil(strlen($this->message) / Sms::MAX_NUMBER_OF_CHARACTERS_IN_AN_SMS);

        return $numberOfSms * Sms::COST_PER_SMS;
    }
}
