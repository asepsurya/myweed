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
            <img src="{{ asset('storage/'.$gift->qr) }}" class="w-32 mt-2">
            @endif

            <button onclick="deleteGift({{ $gift->id }})" class="absolute top-2 right-2 text-red-500">✕</button>
        </div>
        @endforeach
    </div>
<script>
function deleteGift(id) {
    Swal.fire({
        title: 'Hapus gift?',
        text: 'Data akan dihapus permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus'
    }).then(result => {
        if (result.isConfirmed) {
            fetch(`/gifts/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(res => res.json())
              .then(() => location.reload());
        }
    });
}
</script>
</x-app-layout>
