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
        $this->apiUrl = config('services.fonnte.api_url', 'https://api.fonnte.com/send-message');
        $this->adminNumber = config('services.admin_whatsapp');
    }

    public function sendAdminNotification(string $message): bool
    {
        if (! $this->adminNumber || ! $this->apiKey) {
            Log::warning('WhatsApp notification skipped: admin number or API key not configured.');

            return false;
        }

        try {
            $response = Http::post($this->apiUrl, [
                'target' => $this->adminNumber,
                'message' => $message,
                'delay' => '0',
            ]);

            $body = $response->json();

            if (isset($body['no']) || $response->successful()) {
                Log::info('WhatsApp admin notification sent.', ['response' => $body]);

                return true;
            }

            Log::error('WhatsApp notification failed.', [
                'status' => $response->status(),
                'response' => $body,
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('WhatsApp notification error: '.$e->getMessage());

            return false;
        }
    }

    public function sendToUser(?string $phone, string $message): bool
    {
        if (! $phone || ! $this->apiKey) {
            return false;
        }

        try {
            $response = Http::post($this->apiUrl, [
                'target' => $phone,
                'message' => $message,
                'delay' => '0',
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('WhatsApp notification error: '.$e->getMessage());

            return false;
        }
    }
}
