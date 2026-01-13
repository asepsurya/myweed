<section class="py-20 px-6 bg-[#f5f0ea]">
    <h2 class="text-3xl text-center mb-10">Galeri</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-5xl mx-auto">
        @foreach ($invitation->galleries as $photo)
            <img src="{{ asset('storage/'.$photo->image) }}"
                 class="rounded-lg shadow-md hover:scale-105 transition">
        @endforeach
    </div>
</section>
