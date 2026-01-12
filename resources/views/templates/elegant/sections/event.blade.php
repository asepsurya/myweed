<section class="py-20 bg-white text-center">
    <h2 class="text-3xl mb-8">Detail Acara</h2>

    <p class="text-lg">
        {{ \Carbon\Carbon::parse($invitation->wedding_date)->translatedFormat('l, d F Y') }}
    </p>

    <p class="mt-4 text-gray-600">{{ $invitation->location }}</p>
</section>
