<section class="py-20 px-6 bg-white text-center">
    <h2 class="text-3xl mb-8">Konfirmasi Kehadiran</h2>

    <form method="POST" action="{{ route('rsvp.store', $invitation->id) }}"
          class="max-w-md mx-auto space-y-4">
        @csrf

        <input type="text" name="name" placeholder="Nama"
               class="w-full border rounded p-3">

        <textarea name="message" placeholder="Ucapan"
                  class="w-full border rounded p-3"></textarea>

        <button class="w-full bg-black text-white py-3 rounded">
            Kirim
        </button>
    </form>
</section>
