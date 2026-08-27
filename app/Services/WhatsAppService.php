<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected ?string $apiKey;
    protected string $apiUrl;
    protected ?string $adminNumber;

    public function __construct()
    {
        $this->apiKey = config('services.fonnte.api_key');
        $this->apiUrl = config('services.fonnte.api_url', 'https://api.fonnte.com/send');
        $this->adminNumber = config('services.admin_whatsapp');
    }

    protected function normalizePhone(?string $phone): ?string
    {
        if (! $phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }

        if (! str_starts_with($phone, '62')) {
            return '62' . $phone;
        }

        return $phone;
    }

    public function sendAdminNotification(string $message): bool
    {
        $adminNumber = $this->normalizePhone($this->adminNumber);

        if (! $adminNumber || ! $this->apiKey) {
            Log::warning('WhatsApp notification skipped: admin number or API key not configured.');

            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->timeout(30)->post($this->apiUrl, [
                'target' => $adminNumber,
                'message' => $message,
                'delay' => '0',
            ]);

            $body = $response->json();

            if ($response->successful() && ($body['status'] ?? false)) {
                Log::info('WhatsApp admin notification sent.', ['response' => $body]);

                return true;
            }

            Log::error('WhatsApp notification failed.', [
                'url' => $this->apiUrl,
                'status' => $response->status(),
                'body' => $body,
                'response' => $response->body(),
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('WhatsApp notification error: '.$e->getMessage());

            return false;
        }
    }

    public function sendToUser(?string $phone, string $message): bool
    {
        $phone = $this->normalizePhone($phone);

        if (! $phone || ! $this->apiKey) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->timeout(30)->post($this->apiUrl, [
                'target' => $phone,
                'message' => $message,
                'delay' => '0',
            ]);

            $body = $response->json();

            if ($response->successful() && ($body['status'] ?? false)) {
                return true;
            }

            Log::error('WhatsApp notification to user failed.', [
                'url' => $this->apiUrl,
                'phone' => $phone,
                'status' => $response->status(),
                'body' => $body,
                'response' => $response->body(),
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('WhatsApp notification error: '.$e->getMessage());

            return false;
        }
    }
}
