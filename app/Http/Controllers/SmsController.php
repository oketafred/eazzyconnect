<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function create()
    {
        return inertia('Sms/Create');
    }
}
