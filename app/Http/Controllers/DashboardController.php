<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Inertia\Inertia;
use App\Models\Group;
use Illuminate\Support\Number;
use App\Http\Resources\SmsResource;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public const PER_PAGE = 5;

    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            'successfulSmsCount' => Number::format(Auth::user()?->successfulSmsCount()),
            'failedSmsCount' => Number::format(Auth::user()?->failedSmsCount()),
            'groupCount' => Number::format(Group::query()->count()),
            'accountBalance' => Number::format(Auth::user()?->accountBalance()),
            'smses' => $this->getLatestSmses(),
        ]);
    }

    protected function getLatestSmses(): array
    {
        $smses = Sms::query()->latest()->take(self::PER_PAGE)->get();
        return SmsResource::collection($smses)->resolve();
    }
}
