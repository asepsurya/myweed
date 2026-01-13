<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Pasangan') }}
            </h2>
            <a href="{{ route('invitation.create') }}" class="btn-sm inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                + Buat Undangan
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach ($invitations as $inv)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex items-center gap-4">
                    <!-- Thumbnail kiri -->
                    <div class="flex-shrink-0 w-24 h-24">
                        <img src="{{ $inv->gallery_cover ? asset('storage/' . $inv->gallery_cover) : asset('images/default-cover.png') }}" alt="Thumbnail" class="w-70 h-80 object-cover rounded" width="70">
                    </div>

                    <!-- Info kanan -->
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold">
                            {{ $inv->bride_name }} & {{ $inv->groom_name }}
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $inv->wedding_date }}
                        </p>

                        <div class="flex gap-3 mt-4">
                            <a href="{{ url($inv->slug) }}" target="_blank" class="text-blue-600 hover:underline">Preview</a>

                            <a href="{{ route('invitation.edit', $inv) }}" class="text-green-600 hover:underline">Edit</a>

                            <button onclick="openShareForm('{{ $inv->slug }}', '{{ $inv->bride_name }}', '{{ $inv->groom_name }}')" class="text-yellow-600 hover:underline">Share WA</button>
                        </div>
                    </div>
                </div>

                @endforeach

                <!-- Modal WA -->
                <div id="shareModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
                    <div class="bg-white p-6 rounded-lg w-80 max-w-full mx-4">
                        <h3 class="text-lg font-semibold mb-3">Share Undangan via WhatsApp</h3>
                        <form id="waForm" target="_blank">
                            <input type="hidden" id="slug" name="slug">
                            <input type="hidden" id="bride" name="bride">
                            <input type="hidden" id="groom" name="groom">
                            <div class="mb-3">
                                <label class="text-sm">Kepada:</label>
                                <input type="text" id="toName" placeholder="Nama penerima" class="w-full border rounded p-2" required>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeShareForm()" class="px-4 py-2 border rounded hover:bg-gray-100">
                                    Batal
                                </button>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    const baseUrl = @json(url('')); // base URL dari Laravel

                    function openShareForm(slug, bride, groom) {
                        document.getElementById('shareModal').classList.remove('hidden');
                        document.getElementById('slug').value = slug;
                        document.getElementById('bride').value = bride;
                        document.getElementById('groom').value = groom;
                    }

                    function closeShareForm() {
                        document.getElementById('shareModal').classList.add('hidden');
                    }

                    // Submit form WA
                    document.getElementById('waForm').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const slug = document.getElementById('slug').value;
                        const bride = document.getElementById('bride').value;
                        const groom = document.getElementById('groom').value;
                        const toName = encodeURIComponent(document.getElementById('toName').value.trim());

                        const url = `${baseUrl}/${slug}?to=${toName}`;

                        const message = `
Assalamu’alaikum Wr.Wb

Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i ${toName} untuk menghadiri acara pernikahan kami  
${url}
Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu. 
Mohon maaf perihal undangan hanya dibagikan melalui pesan ini, karena keterbatasan jarak & waktu. 
Pesan ini adalah undangan resmi sebagai pengganti apabila undangan cetak BELUM/TIDAK DITERIMA 
oleh Bapak/Ibu/Saudara/I Diharapkan melalui media ini sebagai pengganti undangan resmi maksud dan tujuan kami dapat tersampaikan. 
Terima kasih banyak atas perhatiannya. 

Kami yang berbahagia,
${bride} & ${groom}
`;

                        const waUrl = 'https://wa.me/?text=' + encodeURIComponent(message);
                        window.open(waUrl, '_blank');

                        closeShareForm();
                    });

                </script>

            </div>
        </div>
    </div>
</x-app-layout>
