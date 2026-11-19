<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'type',
        'content',
        'excerpt',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
        'type' => 'string',
        'content' => 'string',
        'excerpt' => 'string',
        'image' => 'string',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeInspirasi($query)
    {
        return $query->where('type', 'inspirasi');
    }

    public function scopePanduan($query)
    {
        return $query->where('type', 'panduan');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Ringkasan teks bersih dari konten (HTML dibuang, entity di-decode).
     * Dipakai untuk preview di daftar artikel.
     */
    public function getSnippetAttribute(): string
    {
        $text = html_entity_decode(
            strip_tags((string) $this->content),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        // \u{00A0} = non-breaking space dari &nbsp;
        $text = str_replace("\u{00A0}", ' ', $text);
        $text = trim(preg_replace('/\s+/u', ' ', $text));

        if ($text === '') {
            $text = trim((string) $this->excerpt);
        }

        return $text;
    }
}
