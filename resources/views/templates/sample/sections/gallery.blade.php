<section class="py-16 text-center">
    <h2 class="text-2xl font-serif mb-6">Galeri Penganten</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($galleries ?? [] as $image)
            <img src="{{ $image }}" class="rounded-lg border border-[#D4AF37]">
        @endforeach
    </div>
</section>