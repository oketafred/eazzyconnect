<?php

namespace App\Http\Controllers;

use App\Models\SmsBundle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SmsBundleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('SmsBundle/Index');
    }
}
