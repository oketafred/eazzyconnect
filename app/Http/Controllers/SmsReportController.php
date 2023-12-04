<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SmsReportController extends Controller
{
    public function index()
    {
        return Inertia::render('SmsReport/Index', [
            'smses' => Sms::query()
                ->orderByDesc('id')
                ->paginate(20)
                ->withQueryString()
                ->through(fn($sms) => [
                    'id' => $sms->id,
                    'createdAt' => $sms->created_at,
                    'message' => $sms->message,
                    'phoneNumber' => $sms->phone_number,
                    'status' => $sms->status,
                    'messageId' => $sms->messageId,
                    'failureReason' => $sms->failure_reason,
                ]),
        ]);
    }
}
