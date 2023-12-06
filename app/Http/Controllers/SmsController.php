<?php

namespace App\Http\Controllers;

use App\Jobs\SendBulkSmsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SmsController extends Controller
{
    public function create()
    {
        return inertia('Sms/Create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $phone_numbers = explode(',', $request->input('phone_number'));
        $message = $request->input('message');
        $user = Auth::user();

        foreach ($phone_numbers as $phone_number) {
            Log::info("Dispatch Bulk SMS job for: $phone_number");
            SendBulkSmsJob::dispatch($phone_number, $message, $user);
        }

        return redirect()->back()->with('success', 'SMS sending is in process');
    }
}
