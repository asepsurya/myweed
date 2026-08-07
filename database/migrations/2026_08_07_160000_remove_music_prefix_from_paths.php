<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Music;

return new class extends Migration
{
    public function up(): void
    {
        Music::where('audio_url', 'like', 'music/%')->chunk(100, function ($items) {
            foreach ($items as $m) {
                $m->audio_url = ltrim(preg_replace('#^music/#', '', $m->audio_url), '/');
                if ($m->music_url && str_starts_with($m->music_url, 'music/')) {
                    $m->music_url = ltrim(preg_replace('#^music/#', '', $m->music_url), '/');
                }
                $m->save();
            }
        });
    }

    public function down(): void
    {
        Music::where('audio_url', 'not like', 'music/%')->chunk(100, function ($items) {
            foreach ($items as $m) {
                $m->audio_url = 'music/' . ltrim($m->audio_url, '/');
                if ($m->music_url && !str_starts_with($m->music_url, 'music/')) {
                    $m->music_url = 'music/' . ltrim($m->music_url, '/');
                }
                $m->save();
            }
        });
    }
};
