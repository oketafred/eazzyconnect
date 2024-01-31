<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RelworxMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $relworx_header = explode(",", $request->header('relworx-signature'));
        $relworxSignature = Str::after($relworx_header[1], 'v=');

        $timestamp = Str::after($relworx_header[0], 't=');
        $url = $request->fullUrl();
        $webhook_key = config('relworx.webhook_key');

        $params = array(
            "status" => $request->get('status'),
            "customer_reference" => $request->get('customer_reference'),
            "internal_reference" => $request->get('internal_reference'),
        );

        $generatedSignature = $this->generateSignature($webhook_key, $timestamp, $url, $params);

        if ($relworxSignature === $generatedSignature) {
            return $next($request);
        }

        return response()->json([
            'status-code' => 401,
            'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }

    private function generateSignature($webhook_key, $timestamp, $url, $params): string
    {
        $signed_data = $url;
        $signed_data .= $timestamp;
        ksort($params);
        foreach ($params as $key => $value) {
            $signed_data .= strval($key);
            $signed_data .= strval($value);
        }

        return hash_hmac('sha256', $signed_data, $webhook_key, false);
    }
}
