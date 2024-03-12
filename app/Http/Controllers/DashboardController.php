<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Inertia\Inertia;
use App\Models\Group;
use Inertia\Response;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'successfulSmsCount' => Number::format(Auth::user()?->successfulSmsCount()),
            'failedSmsCount' => Number::format(Auth::user()?->failedSmsCount()),
            'groupCount' => Number::format(Group::query()->count()),
            'accountBalance' => Number::format(Auth::user()?->accountBalance()),
            'smses' => Sms::query()->latest()->take(5)->get()->map(function ($sms) {
                return [
                    'id' => $sms->id,
                    'created_at' => $sms->created_at->diffForHumans(),
                    'message' => $sms->message,
                    'phone_number' => $sms->phone_number,
                    'status' => $sms->status,
                ];
            }),
        ]);
    }
}
