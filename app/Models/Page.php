<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'template',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

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
     * Dipakai untuk preview di daftar halaman.
     */
    public function getSnippetAttribute(): string
    {
        $text = html_entity_decode(
            strip_tags((string) $this->content),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $text = str_replace("\u{00A0}", ' ', $text);
        $text = trim(preg_replace('/\s+/u', ' ', $text));

        if ($text === '') {
            $text = trim((string) $this->excerpt);
        }

        return $text;
    }

    /**
     * Judul SEO: pakai meta_title bila diisi, jika tidak pakai judul halaman.
     */
    public function getSeoTitleAttribute(): string
    {
        $title = trim((string) $this->meta_title);

        return $title !== '' ? $title : $this->title;
    }

    /**
     * Label template halaman untuk ditampilkan di panel admin.
     */
    public function getTemplateLabelAttribute(): string
    {
        return match ($this->template) {
            'full' => 'Lebar Penuh',
            'minimal' => 'Minimal',
            default => 'Standar',
        };
    }

    /**
     * URL publik halaman.
     */
    public function getUrlAttribute(): string
    {
        return route('pages.show', $this->slug);
    }
}
