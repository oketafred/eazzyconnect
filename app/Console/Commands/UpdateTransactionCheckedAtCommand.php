<?php

namespace App\Console\Commands;

use App\Models\SmsBundle;
use App\Services\FlutterwaveService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateTransactionCheckedAtCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eazzyconnect:update-transaction-checked-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update transaction checked_at command';

    /**
     * Execute the console command.
     */
    public function handle(FlutterwaveService $flutterwaveService)
    {
        $transactions = SmsBundle::query()
            ->whereNull('checked_at')
            ->get();

        foreach ($transactions as $transaction) {
            $reference = $transaction->transaction_reference;
            $verificationResult = $flutterwaveService->verifyTransactionByReference($reference);

            if (
                $verificationResult['status'] === SmsBundle::STATUS_ERROR &&
                $verificationResult['data'] === null
            ) {
                $transaction->update([
                    'status' => SmsBundle::STATUS_FAILED_FROM_SYSTEM,
                    'failure_reason' => SmsBundle::FAILED_FROM_SYSTEM_MESSAGE
                ]);
            }

            $transaction->update(['checked_at' => now()]);
        }
    }
}
