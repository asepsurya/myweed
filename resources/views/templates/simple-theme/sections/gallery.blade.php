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
    <div id="gallery" class="animate-on-scroll px-6">
        <i class="ti ti-leaf-heart"></i>

        <h2 class="font-serif text-2xl text-primary text-center mb-4">Galeri</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 fade-in" id="galleryGrid">
            @forelse($invitation->galleries as $index => $photo)
            <div class="gallery-item {{ $index >= 6 ? 'hidden' : '' }}" data-gallery-index="{{ $index }}">
                <div class="{{ $index === 2 ? 'aspect-[4/3] rounded-lg overflow-hidden md:col-span-2' : ($index % 2 === 0 ? 'aspect-[3/4] rounded-lg overflow-hidden' : 'aspect-square rounded-lg overflow-hidden') }}">
                    <a href="{{ storage_url($photo->image) }}" data-fancybox="gallery" data-caption="Wedding Moment">
                        <img loading="lazy"alt="Wedding Moment" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" src="{{ storage_url($photo->image) }}" loading="lazy"/>
                    </a>
                </div>
            </div>
            @empty
            <p class="text-center col-span-full font-body-md text-body-md text-on-surface-variant">Belum ada foto galeri.</p>
            @endforelse
        </div>
        @if($invitation->galleries->count() > 6)
        <div class="text-center mt-8 fade-in">
            <button id="loadMoreGallery" class="border border-primary text-primary px-6 py-2 rounded-full font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary/5 transition-colors" onclick="loadMoreGallery()">
                <span id="loadMoreText">Lihat Lebih Banyak</span>
                <svg id="loadMoreSpinner" class="animate-spin hidden inline-block ml-2" style="width:18px;height:18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </button>
        </div>
        @endif
    </div>

    <!-- Include Fancybox CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>



