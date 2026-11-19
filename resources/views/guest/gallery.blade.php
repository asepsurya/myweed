<x-app-layout>
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6">
    <div class="max-w-2xl mx-auto">
        
        <!-- Gallery Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-indigo-800 mb-1">Galeri Foto Tamu</h2>
            <p class="text-gray-600">Total foto: <span id="totalPhotos" class="font-medium"></span></p>
        </div>
        
        <!-- Photos Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="photosGrid">
            @if($photos->isEmpty())
            <div class="col-span-full text-center py-8 text-gray-500">
                <i class="bi bi-image text-4xl mb-3"></i>
                <p>Belum ada foto dari tamu</p>
            </div>
            @else
            @foreach($photos as $photo)
            <div class="rounded-3 overflow-hidden hover:shadow-lg transition-shadow" style="aspect-ratio: 16/9;">
                <img src="{{ $photo->image_url }}" alt="Foto tamu" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-xs p-2">
                    <span>{{ $photo->guest_name }}</span>
                </div>
            </div>
@endforeach
          
        </div>
        
@endif

        <!-- Empty state when no photos -->
        @if($photos->isEmpty())
        <div class="col-span-full text-center py-12 text-gray-500">
            <i class="bi bi-cloud-download text-3xl mb-3"></i>
            <p>Tamu belum mengunggah foto</p>
            <p class="mt-2 text-sm">Minta tamu scan QR code di undangan untuk ikut berpartisipasi</p>
        </div>
        @endif
    </div>
</div>


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventId = "{{ $event_id }}";
    const photosGrid = document.getElementById('photosGrid');
    const totalPhotosSpan = document.getElementById('totalPhotos');
    
    // Fetch photos from API
    fetch(`/api/guest-photos/${eventId}`, {
      headers: {
        'X-Secret-Token': 'guest-photos-secret-2026'
      }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            const photos = data.data;
            totalPhotosSpan.textContent = photos.length;
            
            if (photos.length === 0) {
                photosGrid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500"><i class="bi bi-image text-4xl mb-3"></i><p>Belum ada foto dari tamu</p></div>';
                return;
            }
            
            let html = '';
            photos.forEach((photo, index) => {
                html += `
                <div class="rounded-3 overflow-hidden hover:shadow-lg transition-shadow" style="aspect-ratio: 16/9;">
                    <img src="${photo.image_url}" alt="Foto tamu" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-xs p-2">
                        <span>${photo.guest_name}</span>
                    </div>
                </div>
                `;
            });
            
            photosGrid.innerHTML = html;
        } else {
            photosGrid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500"><i class="bi bi-exclamation-triangle text-danger"></i><p>Gagal memuat galeri</p></div>';
        }
    })
    .catch(error => {
        console.error('Error fetching photos:', error);
        photosGrid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500"><i class="bi bi-exclamation-triangle text-danger"></i><p>Gagal memuat galeri</p></div>';
    });
});
</script>
</x-app-layout>