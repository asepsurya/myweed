@php
    $siteName = config('app.name', 'RuangUndang');
    $displayTitle = $seoTitle ?? ((!empty($invitation->groom_nickname) && !empty($invitation->bride_nickname)) 
        ? ($invitation->groom_nickname . ' & ' . $invitation->bride_nickname . ' | Undangan Pernikahan') 
        : ($invitation->title ?? 'Undangan Pernikahan - RuangUndang'));
    
    $displayDescription = $seoDescription ?? ('Undangan pernikahan digital' . 
        ((!empty($invitation->groom_name) && !empty($invitation->bride_name)) 
            ? (' ' . $invitation->groom_name . ' & ' . $invitation->bride_name) 
            : '') . '. Buka undangan untuk melihat detail acara, lokasi, dan RSVP.');

    $canonical = $canonicalUrl ?? (isset($invitation->slug) ? route('invitation.show', $invitation->slug) : url()->current());
    
    // Fallback image
    $displayImage = $seoImage ?? (
        isset($invitation) && !empty($invitation->gallery_cover) 
            ? storage_url($invitation->gallery_cover, optional($invitation->updated_at)->timestamp) 
            : asset('assets/og-image.png')
    );
    
    $isNoIndex = $noIndex ?? false;
@endphp

<title>{{ $displayTitle }}</title>
<meta name="description" content="{{ $displayDescription }}">
@if(!empty($seoKeywords))
<meta name="keywords" content="{{ $seoKeywords }}">
@endif
<meta name="author" content="{{ $siteName }}">

@if($isNoIndex)
<meta name="robots" content="noindex, nofollow">
@else
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
@endif

<link rel="canonical" href="{{ $canonical }}">

<!-- Open Graph / Facebook -->
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="id_ID">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $displayTitle }}">
<meta property="og:description" content="{{ $displayDescription }}">
<meta property="og:image" content="{{ $displayImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $canonical }}">
<meta name="twitter:title" content="{{ $displayTitle }}">
<meta name="twitter:description" content="{{ $displayDescription }}">
<meta name="twitter:image" content="{{ $displayImage }}">

<link rel="icon" type="image/png" href="{{ asset('assets/fav-icon.png') }}">

@if(isset($jsonLd) && !empty($jsonLd))
@foreach($jsonLd as $ld)
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endforeach
@endif
