<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Gift Digital</h2>

    <form action="/gifts" method="POST" enctype="multipart/form-data" class="space-y-3">
        @csrf
        {{-- <input type="hidden" name="invitation_id" value="{{ $invitationId }}"> --}}

        <input type="text" name="bank" placeholder="Bank / E-Wallet" class="input">
        <input type="text" name="number" placeholder="Nomor Rekening / HP" class="input">
        <input type="text" name="name" placeholder="Atas Nama" class="input">
        <input type="file" name="qr" class="input">

        <button class="btn-primary">Tambah Gift</button>
    </form>

    <hr class="my-6">

    <div class="grid md:grid-cols-2 gap-4">
        @foreach($gifts as $gift)
        <div class="border p-4 rounded relative">
            <p class="font-semibold">{{ $gift->bank }}</p>
            <p>{{ $gift->number }}</p>
            <p class="text-sm text-gray-500">a.n {{ $gift->name }}</p>

            @if($gift->qr)
            <img src="{{ $gift->qr ? '/storage/'.$gift->qr : '' }}" class="w-32 mt-2">
            @endif

            <form action="{{ route('gift.destroy', $gift->id) }}" method="POST" class="absolute top-2 right-2"
                  onsubmit="return confirm('Hapus gift ini? Data yang sudah dihapus tidak dapat dikembalikan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">✕</button>
            </form>
        </div>
        @endforeach
    </div>
</x-app-layout>

