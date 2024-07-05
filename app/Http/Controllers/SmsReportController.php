<?php

namespace App\Http\Controllers;

use App\Http\Resources\SmsResource;
use App\Models\Sms;
use Inertia\Inertia;

class SmsReportController extends Controller
{
    public const PER_PAGE = 20;

    public function __invoke()
    {
        $smses = Sms::query()
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return Inertia::render('SmsReport/Index', [
            'smses' => SmsResource::collection($smses),
        ]);
    }
}
