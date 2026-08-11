<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MayarService
{
    protected string $baseUrl;

    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.mayar.base_url', env('MAYAR_BASE_URL', 'https://api.mayar.id/hl/v2')), '/');
        $this->apiKey = config('services.mayar.api_key', env('MAYAR_API_KEY'));
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function createPaymentLink(array $data): array
    {
        $payload = [
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'amount' => (int) $data['amount'],
            'redirectUrl' => $data['redirect_url'] ?? route('payment.success'),
            'notes' => $data['notes'] ?? '',
            'expiredAt' => $data['expired_at'] ?? null,
        ];

        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl.'/products/payment-link/create', $payload);

        Log::info('Mayar create payment link', [
            'payload' => $payload,
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        if ($response->successful() && $response->json('statusCode') === 200) {
            return [
                'success' => true,
                'data' => $response->json('data'),
            ];
        }

        return [
            'success' => false,
            'message' => $response->json('messages') ?? 'Failed to create payment link',
            'status' => $response->status(),
        ];
    }

    public function getTransactionDetail(string $transactionId): array
    {
        $response = Http::withHeaders($this->headers())
            ->get($this->baseUrl.'/transaction/detail', [
                'id' => $transactionId,
            ]);

        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json('data'),
            ];
        }

        return [
            'success' => false,
            'message' => $response->json('messages') ?? 'Failed to get transaction detail',
        ];
    }

    public function registerWebhook(string $url): array
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl.'/webhooks/update', [
                'urlHook' => $url,
            ]);

        if ($response->successful() && $response->json('statusCode') === 200) {
            return ['success' => true];
        }

        return [
            'success' => false,
            'message' => $response->json('messages') ?? 'Failed to register webhook',
        ];
    }
}
