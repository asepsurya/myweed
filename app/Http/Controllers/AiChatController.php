<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use League\CommonMark\CommonMarkConverter;

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

                $converter = new CommonMarkConverter([
                    'html_input' => 'escape',
                    'allow_unsafe_links' => false,
                ]);

                $reply = trim($reply);
                $hasFallback = str_contains($reply, '[WA_FALLBACK]');
                $reply = str_replace('[WA_FALLBACK]', '', $reply);
                $reply = trim($reply);
                $replyHtml = $converter->convert($reply)->getBody()->getContent();

                return response()->json([
                    'success' => true,
                    'reply' => $replyHtml,
                    'reply_text' => $reply,
                    'has_fallback' => $hasFallback,
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
Kamu adalah asisten panduan aplikasi RuangUndang. Tugasmu adalah membantu pengguna menggunakan aplikasi dan membuat undangan pernikahan digital.

Peran dan aturan:
1. Jawab dalam Bahasa Indonesia yang santai, ramah, dan jelas.
2. Pandu pengguna langkah demi langkah menggunakan fitur RuangUndang:
   - Membuat undangan, memilih tema, mengedit data mempelai, mengupload foto, mengatur musik, membagikan undangan, berlangganan premium, dll.
3. Jika pertanyaan tidak berhubungan dengan RuangUndang atau kamu tidak yakin jawabannya, katakan:
   "Untuk pertanyaan ini, saya sarankan langsung chat via WhatsApp agar tim kami bisa bantu lebih cepat."
4. Setiap kali kamu tidak bisa menjawab, AKHIRI pesan dengan baris: [WA_FALLBACK]
5. Gunakan format markdown yang rapi agar tampilannya enak dibaca di chat, misalnya:
   - Gunakan **bold** untuk menekankan kata penting
   - Gunakan - atau * untuk daftar
   - Jangan gunakan heading markdown terlalu panjang
6. Setelah data penting terpenuhi (nama pria & wanita, tanggal), beri opsi untuk buat undangan.
7. Jika pengguna menanyakan tentang langganan atau premium, sebutkan kata "Langganan" dengan jelas agar tombol aksi dapat muncul.
PROMPT;

        if ($user) {
            $basePrompt .= "\n\nInfo pengguna saat ini: Nama: {$user->name}, Email: {$user->email}.";
        }

        return $basePrompt;
    }
}
