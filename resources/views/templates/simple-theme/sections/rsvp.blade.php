<!-- RSVP -->
@if($invitation->enable_rsvp === 1)
<div class="bg-primary/10 p-6 rounded-xl animate-on-scroll px-6">
    <h2 class="font-serif text-2xl text-primary text-center mb-4">Berikan Ucapan & Doa Restu Anda</h2>
    <form id="rsvpForm" class="space-y-4 max-w-md mx-auto">
        @csrf
        <input class="w-full px-4 py-2 rounded border" placeholder="Nama" name="name">
        <select class="w-full px-4 py-2 rounded border" name="attending">
            <option value="1">Hadir</option>
            <option value="0">Tidak Hadir</option>
        </select>
        <textarea id="rsvpMessageInput" class="w-full px-4 py-2 rounded border resize-none overflow-hidden" rows="3"
            placeholder="Doa & Ucapan" name="message" style="height:100px; max-height:300px;"></textarea>

        <script>
            // Auto height textarea
            const textarea = document.getElementById('rsvpMessageInput');

            textarea.addEventListener('input', function() {
                this.style.height = 'auto'; // reset dulu
                this.style.height = Math.min(this.scrollHeight, 300) + 'px'; // auto expand sampai max 300px
            });
        </script>
        <button id="rsvpButton"
            class="w-full bg-primary text-white py-2 rounded-full flex justify-center items-center gap-2"
            type="submit">
            <span id="buttonText">Kirim</span>
            <svg id="buttonSpinner" class="w-5 h-5 text-white animate-spin hidden" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
        </button>

    </form>


    <div id="rsvpMessage" class="max-w-md mx-auto mt-4 text-center text-green-600"></div>

    <div class="mt-6 p-4 bg-white rounded-lg">
        <h4 class="center font-serif text-lg text-primary mb-4">Tinggalkan kami doa terbaik anda
            untuk momen bahagia kami</h4>

        <div id="rsvpList" class="space-y-3 max-h-64 overflow-y-auto">
            <!-- Daftar RSVP akan di-load di sini -->
        </div>
        <center> <span class="text-sm text-gray-600 mb-2"> ({{ $invitation->rsvps->count() }} Ucapan & Doa Restu)</span>
        </center>
    </div>

    <script>
        const invitationId = "{{ $invitation->id }}";

       function renderRsvpList(rsvps) {
            const list = document.getElementById('rsvpList');

            // Jika belum ada data
            if (!rsvps || rsvps.length === 0) {
                list.innerHTML = `
                    <div class="text-center text-gray-500 text-sm py-6">
                        Belum ada ucapan 🥲
                        <br>Jadilah yang pertama memberi doa 💖
                    </div>
                `;
                return;
            }

           list.innerHTML = rsvps.map(rsvp => `
            <div class="flex justify-start items-center text-sm p-3 bg-gray-50 rounded space-x-3">
                <img src="{{ asset('tempelate/user_default.jpg') }}" 
                    alt="User" 
                    class="w-8 h-8 rounded-full object-cover">
                <div>
                    <p class="font-semibold">${rsvp.name}</p>
                    <p class="text-gray-600 text-xs">${rsvp.message}</p>
                </div>
            </div>
        `).join('');

        }

        // Load RSVP list dari server
        function updateRsvpList() {
            fetch(`/invitation/${invitationId}/rsvps`)
                .then(res => res.json())
                .then(data => renderRsvpList(data))
                .catch(err => {
                    console.error(err);
                    document.getElementById('rsvpList').innerHTML = `
                        <div class="text-center text-red-500 text-sm py-6">
                            Gagal memuat data RSVP 😢
                        </div>
                    `;
                });
        }


        const form = document.getElementById('rsvpForm');
        const button = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading + text "Mengirim..."
            button.disabled = true;
            buttonText.innerText = "Mengirim...";
            buttonSpinner.classList.remove('hidden');

            const formData = new FormData(form);

            fetch("{{ route('rsvp.store', $invitation->id) }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        form.reset(); // clear form
                        document.getElementById('rsvpMessage').innerText = data.message ||
                            "RSVP berhasil dikirim!";
                        updateRsvpList(); // refresh list
                    } else {
                        document.getElementById('rsvpMessage').innerText = data.message || "Terjadi kesalahan.";
                    }
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById('rsvpMessage').innerText = "Terjadi kesalahan saat mengirim RSVP.";
                })
                .finally(() => {
                    // Kembalikan tombol ke normal
                    button.disabled = false;
                    buttonText.innerText = "Kirim";
                    buttonSpinner.classList.add('hidden');
                });
        });

        // Auto-refresh setiap 3 detik
        setInterval(updateRsvpList, 3000);

        // Load pertama kali
        updateRsvpList();
    </script>
</div>
@endif
