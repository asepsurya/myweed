@php
    $siteName = config('app.name', 'RuangUndang');
    $appUrl = config('app.url');
    $currentUrl = url()->current();
    $canonical = $canonicalUrl ?? $currentUrl;

    $pageTitle = $seoTitle ?? ($title ?? "$siteName - Platform Undangan Digital Premium & Elegant");
    $pageDescription = $seoDescription ?? 'Buat undangan pernikahan digital yang elegan dan modern. Pilih dari puluhan tema eksklusif, bagikan via WhatsApp, dan lacak RSVP tamu secara real-time.';
    $pageKeywords = $seoKeywords ?? 'undangan digital, undangan pernikahan, undangan online, template undangan, undangan murah, undangan elegan';
    $pageImage = $seoImage ?? asset('assets/og-image.png');
    $pageType = $seoType ?? 'website';
    $pageLang = 'id';
    $noIndex = $noIndex ?? false;
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
<meta name="keywords" content="{{ $pageKeywords }}">
<meta name="author" content="{{ $siteName }}">
@if($noIndex)
<meta name="robots" content="noindex, nofollow">
@else
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
@endif
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:locale" content="id_ID">
<meta property="og:type" content="{{ $pageType }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $currentUrl }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:image" content="{{ $pageImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $pageTitle }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageImage }}">

<link rel="alternate" hreflang="id" href="{{ $currentUrl }}">
<link rel="alternate" hreflang="x-default" href="{{ $currentUrl }}">

@if(isset($jsonLd) && !empty($jsonLd))
@foreach($jsonLd as $ld)
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endforeach
@endif

@hasSection('jsonLd')
@yield('jsonLd')
@endif