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
        $baseUrl = rtrim(config('app.url'), '/');

        $urls = [];

        $staticPages = [
            ['loc' => $baseUrl.'/', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $baseUrl.'/cari-tema', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => $baseUrl.'/fitur', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $baseUrl.'/harga', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => $baseUrl.'/bantuan', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => $baseUrl.'/faq', 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => $baseUrl.'/cara-pemesanan', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => $baseUrl.'/syarat-ketentuan', 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => $baseUrl.'/kebijakan-privasi', 'changefreq' => 'monthly', 'priority' => '0.5'],
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
                'lastmod' => $template->updated_at ? Carbon::parse($template->updated_at)->toAtomString() : null,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        $invitations = Invitation::with('template')
            ->whereHas('template')
            ->whereNotNull('slug')
            ->where('is_default', false)
            ->orderByDesc('updated_at')
            ->get(['id', 'slug', 'groom_name', 'bride_name', 'updated_at']);

        foreach ($invitations as $invitation) {
            $urls[] = [
                'loc' => $baseUrl.'/'.$invitation->slug,
                'lastmod' => $invitation->updated_at ? Carbon::parse($invitation->updated_at)->toAtomString() : null,
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        $xml = view('sitemap', compact('urls', 'baseUrl'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
