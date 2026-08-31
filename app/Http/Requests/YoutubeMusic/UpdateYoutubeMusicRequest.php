<?php

namespace App\Http\Requests\YoutubeMusic;

use Illuminate\Foundation\Http\FormRequest;

class UpdateYoutubeMusicRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'artist' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['required', 'url', 'max:2048'],
            'cover_url' => ['nullable', 'url', 'max:2048'],
            'is_active' => ['boolean'],
        ];
    }
}
