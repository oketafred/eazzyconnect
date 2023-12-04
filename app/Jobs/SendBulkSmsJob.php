<?php

namespace App\Jobs;

use App\Models\Sms;
use App\Models\User;
use App\Services\AfricasTalkingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $phone_number,
        public string $message,
        public User $user
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(AfricasTalkingService $africasTalkingService): void
    {
        try {
            $response = $africasTalkingService->sendSms($this->phone_number, $this->message);

//            dd($response['SMSMessageData']['Recipients'][0]);

            $this->user->smses()->create([
                'cost' => $response['SMSMessageData']['Recipients'][0]['cost'],
                'phone_number' => $response['SMSMessageData']['Recipients'][0]['number'],
                'status' => $response['SMSMessageData']['Recipients'][0]['status'],
                'messageId' => $response['SMSMessageData']['Recipients'][0]['messageId'],
                'message' => $this->message
            ]);

            Log::info(json_encode($response));
        } catch (Throwable $throwable) {
            Log::error($throwable);
        }
    }
}
