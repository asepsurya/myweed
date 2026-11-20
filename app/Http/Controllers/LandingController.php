<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Invitation;
use App\Models\Promotion;
use App\Models\SubscriptionPlan;
use App\Models\Template;
use App\Models\TemplateType;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $realCategories = Category::ordered()->get();

        $query = Template::where('is_active', true)
            ->with('category', 'templateType')
            ->orderByDesc('id');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->has('category') && $request->category != 'All') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $templates = $query->get();

        $invitations = Invitation::with(['template', 'galleries'])
            ->where('status', Invitation::STATUS_PUBLISHED)
            ->latest()
            ->take(12)
            ->get();

        $categories = $realCategories->map(function ($cat) {
            return [
                'name' => $cat->name,
                'icon' => $cat->icon,
                'icon_svg' => $cat->icon_svg,
                'count' => Template::where('id_category', $cat->id)->count().'+',
                'img' => 'https://picsum.photos/seed/'.strtolower($cat->name).'/400/300',
            ];
        });

        $promotions = Promotion::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $blogs = Blog::withCount(['likes', 'comments'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(4)
            ->get();

        $seoTitle = 'RuangUndang - Platform Undangan Digital Premium & Elegant';
        $seoDescription = 'Buat undangan pernikahan digital yang elegan dan modern. Pilih dari puluhan tema eksklusif, bagikan via WhatsApp, dan lacak RSVP tamu secara real-time. Gratis!';
        $seoKeywords = 'undangan digital, undangan pernikahan, undangan online, template undangan, undangan murah, undangan elegan, undangan modern, undangan islami';
        $seoImage = asset('assets/og-image.png');

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => 'RuangUndang',
                'url' => config('app.url'),
                'description' => $seoDescription,
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => config('app.url').'/cari-tema?search={search_term_string}',
                    ],
                    'query-input' => 'required name=search_term_string',
                ],
                'inLanguage' => 'id-ID',
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'RuangUndang',
                'url' => config('app.url'),
                'logo' => asset('assets/logo-new.png'),
                'description' => 'Platform undangan digital premium untuk pernikahan dan momen spesial.',
                'sameAs' => [
                    config('services.socials.facebook'),
                    config('services.socials.instagram'),
                    config('services.socials.tiktok'),
                    config('services.socials.youtube'),
                    config('services.socials.x'),
                    config('services.socials.linkedin'),
                ],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => '+62-859-2343-1716',
                    'contactType' => 'customer service',
                    'availableLanguage' => ['Indonesian'],
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                'name' => 'RuangUndang - Platform Undangan Digital',
                'description' => 'Platform pembuatan undangan digital dan undangan pernikahan online premium. Pilih template eksklusif, bagikan via WhatsApp, dan lacak RSVP tamu secara real-time.',
                'url' => config('app.url'),
                'logo' => asset('assets/logo-new.png'),
                'image' => asset('assets/og-image.png'),
                'telephone' => '+62-859-2343-1716',
                'priceRange' => '$$',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressCountry' => 'ID',
                    'addressLocality' => 'Indonesia',
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => '-6.2088',
                    'longitude' => '106.8456',
                ],
                'sameAs' => [
                    config('services.socials.facebook'),
                    config('services.socials.instagram'),
                    config('services.socials.tiktok'),
                    config('services.socials.youtube'),
                    config('services.socials.x'),
                    config('services.socials.linkedin'),
                ],
                'openingHoursSpecification' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => 'Koleksi Template Undangan Digital',
                'description' => 'Pilihan template undangan digital premium untuk pernikahan',
                'numberOfItems' => $templates->count(),
                'itemListElement' => $templates->take(10)->values()->map(function ($t, $i) {
                    return [
                        '@type' => 'ListItem',
                        'position' => $i + 1,
                        'name' => $t->name,
                        'url' => config('app.url').'/templates/'.$t->slug.'/'.$t->id,
                    ];
                })->toArray(),
            ],
        ];

        return view('index', compact(
            'templates', 'categories', 'invitations', 'promotions', 'blogs',
            'seoTitle', 'seoDescription', 'seoKeywords', 'seoImage', 'jsonLd'
        ));
    }

    public function caraPemesanan()
    {
        $seoTitle = 'Cara Pemesanan - RuangUndang';
        $seoDescription = 'Pelajari cara memesan dan membuat undangan digital di RuangUndang. Proses mudah, cepat, dan tanpa ribet. Mulai dari pilih tema hingga bagikan ke tamu.';
        $seoKeywords = 'cara pemesanan, cara buat undangan, tutorial undangan digital, pesan undangan online';

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'HowTo',
                'name' => 'Cara Membuat Undangan Digital di RuangUndang',
                'description' => 'Panduan langkah demi langkah membuat undangan digital',
                'step' => [
                    ['@type' => 'HowToStep', 'name' => 'Daftar Akun', 'text' => 'Buat akun gratis dengan email atau Google'],
                    ['@type' => 'HowToStep', 'name' => 'Pilih Tema', 'text' => 'Pilih dari puluhan template undangan digital premium'],
                    ['@type' => 'HowToStep', 'name' => 'Isi Data', 'text' => 'Lengkapi informasi acara dan upload foto'],
                    ['@type' => 'HowToStep', 'name' => 'Bagikan', 'text' => 'Dapatkan tautan dan bagikan ke tamu'],
                ],
            ],
        ];

        return view('pages.cara-pemesanan', compact('seoTitle', 'seoDescription', 'seoKeywords', 'jsonLd'));
    }

    public function faq()
    {
        $seoTitle = 'Pertanyaan Umum (FAQ) - RuangUndang';
        $seoDescription = 'Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan undangan digital RuangUndang. Fitur, harga, teknis, dan lainnya.';
        $seoKeywords = 'faq undanyaan digital, pertanyaan umum, bantuan undanyaan, cara pakai undangan';

        return view('pages.faq', compact('seoTitle', 'seoDescription', 'seoKeywords'));
    }

    public function syaratKetentuan()
    {
        $seoTitle = 'Syarat & Ketentuan - RuangUndang';
        $seoDescription = 'Baca syarat dan ketentuan penggunaan layanan undangan digital RuangUndang.';
        $seoKeywords = 'syarat ketentuan, terms and conditions, aturan penggunaan';

        return view('pages.syarat-ketentuan', compact('seoTitle', 'seoDescription', 'seoKeywords'));
    }

    public function kebijakanPrivasi()
    {
        $seoTitle = 'Kebijakan Privasi - RuangUndang';
        $seoDescription = 'Kebijakan privasi dan perlindungan data pengguna layanan undangan digital RuangUndang.';
        $seoKeywords = 'kebijakan privasi, privasi data, perlindungan data';

        return view('pages.kebijakan-privasi', compact('seoTitle', 'seoDescription', 'seoKeywords'));
    }

    public function cariTema(Request $request)
    {
        $realCategories = Category::ordered()->get();
        $realTypes = TemplateType::orderBy('name')->get();

        $query = Template::where('is_active', true)
            ->with('category', 'templateType')
            ->orderByDesc('id');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('templateType', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->has('category') && $request->category != 'All') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->filled('is_premium') && $request->is_premium !== '') {
            $query->where('is_premium', (bool) $request->is_premium);
        }

        if ($request->filled('type') && $request->type !== '') {
            $query->whereHas('templateType', function ($q) use ($request) {
                $q->where('slug', $request->type);
            });
        }

        $sort = $request->query('sort', 'newest');
        if ($sort === 'popular') {
            $query->orderByDesc('views_count')->orderByDesc('likes_count');
        } elseif ($sort === 'name_asc') {
            $query->orderBy('name');
        } elseif ($sort === 'name_desc') {
            $query->orderByDesc('name');
        }

        $templates = $query->paginate(24)->withQueryString();

        $categories = $realCategories->map(function ($cat) {
            return [
                'name' => $cat->name,
                'count' => Template::where('id_category', $cat->id)->count().'+',
            ];
        });

        $templateTypes = $realTypes->map(function ($type) {
            return [
                'name' => $type->name,
                'slug' => $type->slug,
                'color' => $type->color,
                'count' => Template::where('template_type_id', $type->id)->count(),
            ];
        });

        $searchQuery = $request->search;
        $categoryFilter = $request->category;
        $isPremiumFilter = $request->is_premium;
        $typeFilter = $request->type;
        $sortField = $sort;
        $baseParams = $request->except(['_token', 'page']);

        if ($request->ajax()) {
            return response()
                ->view('pages.partials.cari-tema-results', compact(
                    'templates', 'categories', 'templateTypes', 'searchQuery', 'categoryFilter',
                    'isPremiumFilter', 'typeFilter', 'sortField', 'baseParams'
                ))
                ->header('X-Total-Count', (string) $templates->total());
        }

        $canonicalUrl = route('pages.cari-tema');
        $noIndex = ! empty($searchQuery);

        $seoTitle = 'Cari Tema Undangan Digital - RuangUndang';
        $seoDescription = 'Jelajahi koleksi template undangan digital premium. Filter berdasarkan kategori: Modern, Rustic, Floral, Islami, dan lainnya. Temukan tema impian Anda.';
        $seoKeywords = 'cari tema undangan, template undangan, tema pernikahan, undangan modern, undangan rustic, undangan floral, undangan islami';

        if ($searchQuery) {
            $seoTitle = "Cari \"$searchQuery\" - Template Undangan Digital | RuangUndang";
            $seoDescription = "Temukan template undangan digital untuk \"$searchQuery\". Pilihan terlengkap dengan desain premium dan elegan.";
        }

        if ($categoryFilter && $categoryFilter != 'All') {
            $seoTitle = "Tema $categoryFilter - Template Undangan Digital | RuangUndang";
            $seoDescription = "Koleksi template undangan digital bergaya $categoryFilter. Desain eksklusif dan elegan untuk pernikahan impian Anda.";
        }

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Koleksi Template Undangan Digital',
                'description' => $seoDescription,
                'numberOfItems' => $templates->total(),
            ],
        ];

        return view('pages.cari-tema', compact(
            'templates', 'categories', 'templateTypes', 'searchQuery', 'categoryFilter',
            'isPremiumFilter', 'typeFilter', 'sortField', 'baseParams',
            'seoTitle', 'seoDescription', 'seoKeywords', 'jsonLd', 'canonicalUrl', 'noIndex'
        ));
    }

    public function fitur()
    {
        $seoTitle = 'Fitur Unggulan - RuangUndang | Undangan Digital Premium';
        $seoDescription = 'Jelajahi fitur lengkap RuangUndang: Desain mobile-first, background musik, Google Maps, amplop digital, RSVP otomatis, galeri foto, dan masih banyak lagi.';
        $seoKeywords = 'fitur undangan digital, desain responsif, musik undangan, maps undangan, amplop digital, rsvp online';

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Fitur Unggulan RuangUndang',
                'description' => $seoDescription,
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Desain Mobile First'],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Background Musik'],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Google Maps Integrasi'],
                        ['@type' => 'ListItem', 'position' => 4, 'name' => 'Kirim Amplop Digital'],
                        ['@type' => 'ListItem', 'position' => 5, 'name' => 'RSVP & Hitung Tamu'],
                        ['@type' => 'ListItem', 'position' => 6, 'name' => 'Galeri Foto & Video'],
                    ],
                ],
            ],
        ];

        return view('pages.fitur', compact('seoTitle', 'seoDescription', 'seoKeywords', 'jsonLd'));
    }

    public function harga()
    {
        $plans = SubscriptionPlan::all();

        $seoTitle = 'Harga Paket Undangan Digital - RuangUndang';
        $seoDescription = 'Paket harga undangan digital terbaik: Gratis, Basic, dan Pro. Mulai buat undangan impian Anda hari ini tanpa biaya tersembunyi.';
        $seoKeywords = 'harga undangan digital, paket undangan, harga paket, undangan gratis, subscribe undangan';

        $jsonLd = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Harga Paket Undangan Digital',
                'description' => $seoDescription,
            ],
        ];

        if ($plans->isNotEmpty()) {
            $offers = $plans->map(function ($plan) {
                return [
                    '@type' => 'Offer',
                    'name' => $plan->name,
                    'description' => $plan->description,
                    'price' => $plan->is_free ? '0' : number_format($plan->price, 0, '', ''),
                    'priceCurrency' => 'IDR',
                    'url' => config('app.url').'/subscription-plans/'.$plan->id,
                ];
            })->toArray();

            $jsonLd[] = [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => 'Paket Undangan Digital RuangUndang',
                'description' => 'Paket langganan undangan digital premium',
                'offers' => $offers,
            ];
        }

        return view('pages.harga', compact('plans', 'seoTitle', 'seoDescription', 'seoKeywords', 'jsonLd'));
    }

    public function bantuan()
    {
        $seoTitle = 'Pusat Bantuan - RuangUndang';
        $seoDescription = 'Pusat bantuan RuangUndang. Temukan panduan, FAQ, dan hubungi tim support kami untuk membantu kebutuhan undangan digital Anda.';
        $seoKeywords = 'bantuan undanyaan, pusat bantuan, support, kontak, live chat';

        return view('pages.bantuan', compact('seoTitle', 'seoDescription', 'seoKeywords'));
    }
}
