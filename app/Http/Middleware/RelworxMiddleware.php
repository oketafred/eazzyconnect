<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RelworxMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isRequestAuthorized($request)) {
            return $next($request);
        }

        return $this->unauthorizedResponse();
    }

    private function isRequestAuthorized(Request $request): bool
    {
        [$timestamp, $relworxSignature] = $this->parseRelworxHeader($request->header('relworx-signature'));
        $webhookKey = config('relworx.webhook_key');
        $params = $this->getRequestParams($request);
        $generatedSignature = $this->generateSignature($webhookKey, $timestamp, $request->fullUrl(), $params);

        return $relworxSignature === $generatedSignature;
    }

    private function parseRelworxHeader(string $header): array
    {
        $parts = explode(',', $header);
        $timestamp = Str::after($parts[0], 't=');
        $signature = Str::after($parts[1], 'v=');

        return [$timestamp, $signature];
    }

    private function getRequestParams(Request $request): array
    {
        return [
            'status' => $request->get('status'),
            'customer_reference' => $request->get('customer_reference'),
            'internal_reference' => $request->get('internal_reference'),
        ];
    }

    private function generateSignature(string $webhookKey, string $timestamp, string $url, array $params): string
    {
        $signedData = $url . $timestamp;
        ksort($params);
        foreach ($params as $key => $value) {
            $signedData .= $key . $value;
        }

        return hash_hmac('sha256', $signedData, $webhookKey, false);
    }

    private function unauthorizedResponse(): Response
    {
        return response()->json([
            'status-code' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
