<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class EnvSettingController extends Controller
{
    /**
     * Display the settings form.
     */
    public function index()
    {
        $envData = $this->getEnvValues();

        return view('dashboard.settings.env', compact('envData'));
    }

    /**
     * Update the .env file.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // General settings
            'APP_NAME' => 'required|string|max:255',
            'APP_ENV' => 'required|string|in:local,production,staging',
            'APP_DEBUG' => 'required|string|in:true,false',
            'APP_URL' => 'required|url',

            // Database settings
            'DB_HOST' => 'required|string',
            'DB_PORT' => 'required|integer',
            'DB_DATABASE' => 'required|string',
            'DB_USERNAME' => 'required|string',
            'DB_PASSWORD' => 'nullable|string',

            // Mayar configuration
            'MAYAR_BASE_URL' => 'required|url',
            'MAYAR_API_KEY' => 'nullable|string',

            // Midtrans configuration
            'MIDTRANS_SERVER_KEY' => 'nullable|string',
            'MIDTRANS_CLIENT_KEY' => 'nullable|string',
            'MIDTRANS_IS_PRODUCTION' => 'required|string|in:true,false',

            // Mail settings
            'MAIL_HOST' => 'nullable|string',
            'MAIL_PORT' => 'nullable|integer',
            'MAIL_USERNAME' => 'nullable|string',
            'MAIL_PASSWORD' => 'nullable|string',
            'MAIL_FROM_ADDRESS' => 'nullable|email',
            'MAIL_FROM_NAME' => 'nullable|string',

            // OAuth & AI settings
            'GOOGLE_CLIENT_ID' => 'nullable|string',
            'GOOGLE_CLIENT_SECRET' => 'nullable|string',
            'GOOGLE_REDIRECT_URI' => 'nullable|url',
            'AI_SERVER_URL' => 'nullable|url',
            'AI_MODEL_PRIMARY' => 'nullable|string',
            'AI_MODEL_SECONDARY' => 'nullable|string',
            'AI_API_KEY' => 'nullable|string',

            // Storage settings
            'STORAGE_DRIVER' => 'required|string|in:local,r2',
            'R2_ACCESS_KEY_ID' => 'nullable|string',
            'R2_SECRET_ACCESS_KEY' => 'nullable|string',
            'R2_REGION' => 'nullable|string',
            'R2_BUCKET' => 'nullable|string',
            'R2_ENDPOINT' => 'nullable|url',
            'R2_URL' => 'nullable|url',
            'R2_PUBLIC_URL' => 'nullable|url',
        ]);

        // Save keys
        $success = $this->setEnvValues($validated);

        if ($success) {
            // Clear configurations to reflect changes immediately
            try {
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
            } catch (\Exception $e) {
                // Ignore cache clearing errors if artisan behaves weirdly in environment
            }

            return redirect()->back()->with('success', 'Pengaturan .env berhasil diperbarui dan cache konfigurasi dibersihkan.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui file .env. Pastikan file dapat ditulis (writable).');
    }

    /**
     * Parse the .env file.
     */
    private function getEnvValues()
    {
        $envPath = base_path('.env');
        if (! File::exists($envPath)) {
            return [];
        }

        $content = File::get($envPath);
        $lines = explode("\n", $content);
        $values = [];

        foreach ($lines as $line) {
            $line = trim($line);
            // Ignore empty lines and comments
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Strip quotes if they exist
                if (preg_match('/^"(.*)"$/', $value, $matches)) {
                    $value = $matches[1];
                } elseif (preg_match('/^\'(.*)\'$/', $value, $matches)) {
                    $value = $matches[1];
                }

                $values[$key] = $value;
            }
        }

        return $values;
    }

    /**
     * Update the keys in the .env file.
     */
    private function setEnvValues(array $data)
    {
        $envPath = base_path('.env');
        if (! File::exists($envPath)) {
            return false;
        }

        $content = File::get($envPath);

        foreach ($data as $key => $value) {
            $value = $value ?? '';
            // Wrap in quotes if it contains spaces or special characters
            if (preg_match('/\s/', $value) || preg_match('/[#=$]/', $value)) {
                $value = '"'.str_replace('"', '\"', $value).'"';
            }

            // Check if key exists in env content
            // Match KEY=... with m (multiline) flag, checking start of line
            $pattern = '/^'.preg_quote($key, '/').'=(.*)$/m';

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $key.'='.$value, $content);
            } else {
                // If it doesn't exist, append it at the end of the file
                $content .= "\n".$key.'='.$value;
            }
        }

        try {
            File::put($envPath, $content);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
