<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = rtrim(env('APP_URL', config('app.url')), '/');

        $urls = [];

        $staticPages = [
            ['loc' => $baseUrl.'/', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $baseUrl.'/cari-tema', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $baseUrl.'/fitur', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $baseUrl.'/harga', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $baseUrl.'/bantuan', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => $baseUrl.'/faq', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => $baseUrl.'/cara-pemesanan', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => $baseUrl.'/syarat-ketentuan', 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => $baseUrl.'/kebijakan-privasi', 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = $page;
        }

        $templates = Template::where('is_active', true)
            ->orderByDesc('updated_at')
            ->get(['id', 'slug', 'updated_at']);

        foreach ($templates as $template) {
            $urls[] = [
                'loc' => $baseUrl.'/templates/'.$template->slug.'/'.$template->id,
                'lastmod' => $template->updated_at ? Carbon::parse($template->updated_at)->toAtomString() : null,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $xml = view('sitemap', compact('urls', 'baseUrl'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
