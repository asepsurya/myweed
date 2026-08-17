<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    public function chat(Request $request)
    {
        set_time_limit(120);

        $request->validate([
            'message' => 'required|string|max:2000',
            'model' => 'nullable|string|max:255',
            'history' => 'nullable|array|max:50',
        ]);

        $user = $request->user();
        $aiServerUrl = rtrim(env('AI_SERVER_URL'), '/');
        $primaryModel = env('AI_MODEL_PRIMARY', 'gpt-oss:120b-cloud');
        $secondaryModel = env('AI_MODEL_SECONDARY', 'llama3:latest');
        $apiKey = env('AI_API_KEY');

        $model = $request->input('model') ?: $primaryModel;

        $systemPrompt = $this->buildSystemPrompt($user);

        $messages = [];
        if (! empty($systemPrompt)) {
            $messages[] = ['role' => 'system', 'content' => $systemPrompt];
        }

        $history = $request->input('history', []);
        foreach ($history as $entry) {
            $messages[] = [
                'role' => $entry['role'] ?? 'user',
                'content' => $entry['content'] ?? '',
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $request->input('message'),
        ];

        $payload = [
            'model' => $model,
            'messages' => $messages,
            'stream' => false,
            'options' => [
                'temperature' => 0.7,
                'top_p' => 0.9,
                'num_ctx' => 4096,
            ],
        ];

        try {
            $response = Http::timeout(120)
                ->withHeaders(array_filter([
                    'Content-Type' => 'application/json',
                    'Authorization' => $apiKey ? 'Bearer '.$apiKey : null,
                ]))
                ->post($aiServerUrl.'/api/chat', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['message']['content'] ?? $data['response'] ?? 'Maaf, saya tidak dapat memproses permintaan Anda saat ini.';

                return response()->json([
                    'success' => true,
                    'reply' => trim($reply),
                    'model' => $model,
                ]);
            }

            Log::warning('AI chat request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Layanan AI sedang sibuk. Coba lagi sebentar.',
                'fallback' => true,
            ], 502);
        } catch (\Throwable $e) {
            Log::error('AI chat exception', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke layanan AI. Periksa koneksi dan coba lagi.',
                'fallback' => true,
            ], 502);
        }
    }

    private function buildSystemPrompt($user): string
    {
        $basePrompt = <<<'PROMPT'
Kamu adalah asisten undangan pernikahan digital RuangUndang. Tugasmu adalah membantu pengguna membuat undangan pernikahan digital dengan mengumpulkan informasi berikut:
1. Nama mempelai pria dan panggilan (opsional)
2. Nama mempelai wanita dan panggilan (opsional)
3. Tanggal pernikahan
4. Waktu akad (opsional)
5. Waktu resepsi (opsional)
6. Lokasi akad (opsional)
7. Lokasi resepsi (opsional)
8. Quote/doa untuk pasangan (opsional)
9. Tema warna undangan (opsional)

Aturan:
- Jawab dalam Bahasa Indonesia yang santai, ramah, dan jelas.
- Jangan memaksa user mengisi semua data. Cukup kumpulkan yang penting dulu: nama mempelai pria dan wanita, serta tanggal pernikahan.
- Setelah data penting terpenuhi, beri opsi untuk langsung buat undangan atau lanjut isi detail lainnya.
- Jangan gunakan format markdown. Gunakan teks biasa yang mudah dibaca di chat bubble.
- Jika user sudah cukup informasi, katakan: "Informasi sudah cukup! Silakan klik tombol Buat Undangan di bawah chat untuk membuat undangan Anda."
PROMPT;

        if ($user) {
            $basePrompt .= "\n\nInfo pengguna saat ini: Nama: {$user->name}, Email: {$user->email}.";
        }

        return $basePrompt;
    }
}
