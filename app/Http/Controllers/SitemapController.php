<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Template;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = rtrim(app()->environment('production') ? 'https://ruangundang.my.id' : config('app.url'), '/');
        if (app()->environment('production') && str_starts_with($baseUrl, 'http://')) {
            $baseUrl = preg_replace('/^http:/', 'https:', $baseUrl);
        }

        $urls = [];

        $today = Carbon::today()->toAtomString();

        $staticPages = [
            ['loc' => $baseUrl, 'lastmod' => $today, 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $baseUrl.'/cari-tema', 'lastmod' => $today, 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => $baseUrl.'/fitur', 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $baseUrl.'/harga', 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => $baseUrl.'/bantuan', 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => $baseUrl.'/faq', 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => $baseUrl.'/cara-pemesanan', 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => $baseUrl.'/syarat-ketentuan', 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => $baseUrl.'/kebijakan-privasi', 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = $page;
        }

        $templates = Template::where('is_active', true)
            ->orderByDesc('updated_at')
            ->get(['id', 'slug', 'name', 'updated_at']);

        foreach ($templates as $template) {
            $urls[] = [
                'loc' => $baseUrl.'/templates/'.$template->slug.'/'.$template->id,
                'lastmod' => $template->updated_at ? Carbon::parse($template->updated_at)->toAtomString() : $today,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        $invitations = Invitation::with('template')
            ->whereHas('template')
            ->whereNotNull('slug')
            ->where('is_default', false)
            ->where(function ($q) {
                $q->where('status', 'published')
                  ->orWhereNull('status');
            })
            ->whereNotNull('wedding_date')
            ->orderByDesc('updated_at')
            ->get(['id', 'slug', 'groom_name', 'bride_name', 'updated_at']);

        foreach ($invitations as $invitation) {
            $urls[] = [
                'loc' => $baseUrl.'/'.$invitation->slug,
                'lastmod' => $invitation->updated_at ? Carbon::parse($invitation->updated_at)->toAtomString() : $today,
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        $xml = view('sitemap', compact('urls', 'baseUrl'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
