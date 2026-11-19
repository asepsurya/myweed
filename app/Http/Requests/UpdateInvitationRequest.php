<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $invitation = $this->route('invitation');

        if (! $user || ! $invitation) {
            return false;
        }

        return $user->canAccessInvitation($invitation);
    }

    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'template_id' => ['sometimes', 'required', 'exists:templates,id'],
            'invitation_type' => ['nullable', 'string', 'max:50'],
            'slug' => ['sometimes', 'string', 'max:255', Rule::unique('invitations')->ignore($this->route('invitation')->id, 'id')],
            'status' => ['nullable', 'string', 'in:draft,published,expired,trash'],
            'theme_type' => ['nullable', 'string', 'in:basic,premium_exclusive,luxury'],
            'theme_color' => ['nullable', 'string', 'max:255'],
            'primary_color' => ['nullable', 'string', 'max:7'],
            'custom_data' => ['nullable', 'array'],
            'gallery.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,webp', 'max:10240'],
            'gallery_cover' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:10240'],
            'custom_music' => ['nullable', 'file', 'mimes:mp3,wav,ogg', 'max:10240'],
            'foto_pria' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:10240'],
            'foto_wanita' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:10240'],
            'story_photo.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:10240'],
            'love_story.*' => ['nullable', 'string', 'max:5000'],
            'video_link' => ['nullable', 'url'],
            'music_youtube_url' => ['nullable', 'url'],
            'groom_child_order' => ['nullable', 'string', 'max:255'],
            'bride_child_order' => ['nullable', 'string', 'max:255'],
            'wedding_date' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori undangan wajib dipilih.',
            'category_id.exists' => 'Kategori undangan tidak valid.',
            'template_id.required' => 'Template undangan wajib dipilih.',
            'template_id.exists' => 'Template yang dipilih tidak valid.',
            'slug.unique' => 'Slug undangan sudah digunakan.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('custom_data') && is_string($this->custom_data)) {
            $this->merge(['custom_data' => json_decode($this->custom_data, true) ?? []]);
        }
    }
}
