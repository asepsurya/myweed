
    <style>
.masonry-gallery {
    column-count: 2;
    column-gap: 1rem;
}

@media (min-width: 768px) {
    .masonry-gallery {
        column-count: 3;
    }
}

.masonry-item {
    width: 100%;
    margin-bottom: 1rem;
    border-radius: 0.75rem;
    display: block;
}
</style>
<!-- GALLERY -->
    <div class="animate-on-scroll px-6">
        <i class="ti ti-leaf-heart"></i>


        <h2 class="font-serif text-2xl text-primary text-center mb-4">The Memorable Wedding Galleri</h2>
        <!-- FANCY BOX -->
        <div class="masonry-gallery gap-3 mt-6">

                @foreach ($invitation->galleries as $photo)
                    <a href="{{ asset('storage/' . $photo->image) }}" data-fancybox="gallery">
                        <img
                            src="{{ asset('storage/' . $photo->image) }}"
                            class="masonry-item"
                        >
                    </a>
                @endforeach


            {{-- <a href="https://picsum.photos/600?3" data-fancybox="gallery">
                <img src="https://picsum.photos/300?3" class="rounded shadow cursor-pointer">
            </a>
            <a href="https://picsum.photos/600?4" data-fancybox="gallery">
                <img src="https://picsum.photos/300?4" class="rounded shadow cursor-pointer">
            </a>
            <a href="https://picsum.photos/600?5" data-fancybox="gallery">
                <img src="https://picsum.photos/300?5" class="rounded shadow cursor-pointer">
            </a>
            <a href="https://picsum.photos/600?6" data-fancybox="gallery">
                <img src="https://picsum.photos/300?6" class="rounded shadow cursor-pointer">
            </a> --}}
        </div>

    </div>



    <!-- Include Fancybox CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
