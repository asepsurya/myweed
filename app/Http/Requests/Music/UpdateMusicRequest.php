<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMusicRequest extends FormRequest
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
            'album' => ['nullable', 'string', 'max:255'],
            'cover' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'duration' => ['nullable', 'integer', 'min:0'],
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
            'album.max' => 'Nama album tidak boleh melebihi 255 karakter.',
            'cover.mimes' => 'Cover lagu harus berformat JPG, JPEG, PNG, atau WebP.',
            'cover.max' => 'Cover lagu tidak boleh melebihi 5 MB.',
            'duration.integer' => 'Durasi harus berupa angka.',
        ];
    }
}
