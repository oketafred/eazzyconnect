<?php

namespace App\Http\Controllers;

use App\Jobs\SendBulkSmsJob;
use App\Models\Contact;
use App\Models\Group;
use App\Models\Sms;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SmsController extends Controller
{
    public function create()
    {
        return inertia('Sms/Create', [
            'groups' => Group::query()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'nullable|string',
            'group_id' => 'nullable|numeric',
            'smsType' => Rule::in(['group', 'open']),
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first());
        }

        $user = Auth::user();

        $phone_numbers = array_unique(explode(',', $request->input('phone_number')));

        $group_id = $request->input('group_id');
        if ($request->input('smsType') === 'group') {
            $phone_numbers = Contact::query()
                ->where('group_id', $group_id)
                ->pluck('phone_number')
                ->toArray();
        }

        $message = $request->input('message');

        if ($user?->accountBalance() < Sms::COST_PER_SMS) {
            Log::error("Account balance is not is enough");
            return redirect()->back()
                ->with('error', 'Insufficient balance, You need a minimum of UGX 30 to send an SMS');
        }

        $numberOfSms = $this->numberOfSms($message, $phone_numbers);
        $totalSmsPrice = $this->totalSmsPrice($numberOfSms);

        if ($user?->accountBalance() < $totalSmsPrice) {
            return redirect()->back()
                ->with('error', "Insufficient balance, You need a minimum of UGX $totalSmsPrice to send $numberOfSms SMS(es)");
        }

        foreach ($phone_numbers as $phone_number) {
            Log::info("Dispatch Bulk SMS job for: $phone_number");
            SendBulkSmsJob::dispatch($phone_number, $message, $user, $group_id);
        }

        return redirect()->back()->with('success', 'SMS sending is in process');
    }

    private function numberOfSms(string $message, array $phone_numbers): int
    {
        return (int)(ceil(strlen($message) / Sms::MAX_NUMBER_OF_CHARACTERS_IN_AN_SMS) * count($phone_numbers));
    }

    private function totalSmsPrice(int $numberOfSms)
    {
        return $numberOfSms * Sms::COST_PER_SMS;
    }
}
