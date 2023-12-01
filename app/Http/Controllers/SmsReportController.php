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
            'sms' => Sms::all()
        ]);
    }
}
