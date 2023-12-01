<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'successfulSmsCount' => Number::format(Auth::user()?->successfulSmsCount()),
            'failedSmsCount' => Number::format(Auth::user()?->failedSmsCount()),
            'groupCount' => Number::format(Group::query()->count()),
            'smsCredit' => Number::format(Auth::user()?->smsCredit()),
        ]);
    }
}
