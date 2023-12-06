<?php

namespace App\Http\Controllers;

use App\Models\SmsBundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SmsBundleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('SmsBundle/Index', [
            'smsBundles' => SmsBundle::query()
                ->orderByDesc('id')
                ->paginate(20)
                ->withQueryString()
                ->through(fn($sms_bundle) => [
                    'id' => $sms_bundle->id,
                    'createdAt' => $sms_bundle->created_at,
                    'amount' => Number::format($sms_bundle->amount),
                    'numberOfSms' => number_format(floor($sms_bundle->number_of_sms)),
                    'paymentType' => $sms_bundle->payment_type,
                    'status' => ucfirst($sms_bundle->status),
                    'transactionReference' => $sms_bundle->transaction_reference,
                ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'amount' => 'required',
        ]);

        $user = Auth::user();

        $sms_bundle = $request->user()->sms_bundle()->create([
            'amount' =>  $validated['amount'],
            'customer_name' =>  $user?->name,
            'customer_email' =>  $user?->email,
            'transaction_reference' =>  Str::uuid(),
            'sms_unit_price' => SmsBundle::SMS_UNIT_PRICE,
            'number_of_sms' => floor($validated['amount'] / SmsBundle::SMS_UNIT_PRICE),
        ]);

        return response()->json($sms_bundle);
    }

    public function verifyTransaction(Request $request, $transaction_id)
    {
        $r= Http::acceptJson()
            ->withToken("FLWPUBK_TEST-3ff5792905cbfdca6a7016d089688a29-X")
            ->get("https://api.flutterwave.com/v3/transactions/$transaction_id/verify")
            ->throw()
            ->json();

        dd($r);
    }
}
