<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class StoreMusicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'artist' => ['required', 'string', 'max:255'],
            'music_file' => ['required', 'file', 'mimes:mp3,wav,ogg', 'max:20480'],
            'cover' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul lagu wajib diisi.',
            'title.max' => 'Judul lagu tidak boleh melebihi 255 karakter.',
            'artist.required' => 'Nama penyanyi wajib diisi.',
            'artist.max' => 'Nama penyanyi tidak boleh melebihi 255 karakter.',
            'music_file.required' => 'File musik wajib diunggah.',
            'music_file.mimes' => 'File musik harus berformat MP3, WAV, atau OGG.',
            'music_file.max' => 'File musik tidak boleh melebihi 20 MB.',
            'cover.mimes' => 'Cover lagu harus berformat JPG, JPEG, PNG, atau WebP.',
            'cover.max' => 'Cover lagu tidak boleh melebihi 5 MB.',
        ];
    }
}
