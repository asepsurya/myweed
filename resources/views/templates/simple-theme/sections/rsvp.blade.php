<!-- RSVP -->
@if($invitation->enable_rsvp == 1)
<section id="rsvp" class="bg-primary/10 p-6 rounded-xl animate-on-scroll px-6">
    <h2 class="font-serif text-2xl text-primary text-center mb-4">Ucapan</h2>

    @if($invitation->rsvp_deadline)
    <div class="text-center mb-4 fade-in">
        <p class="font-label-sm text-label-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-sm align-middle">calendar_today</span>
            Batas RSVP: {{ \Carbon\Carbon::parse($invitation->rsvp_deadline)->format('d/m/Y') }}
        </p>
    </div>
    @endif

    @if($invitation->rsvp_message)
    <div class="text-center mb-6 fade-in">
        <p class="font-body-md text-body-md text-on-surface-variant italic">"{{ $invitation->rsvp_message }}"</p>
    </div>
    @endif

    <div class="bg-surface p-6 md:p-8 rounded-xl shadow-sm border border-outline-variant/30 mb-8 fade-in">
        <form id="rsvpForm" action="{{ route('rsvp.store', $invitation) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <input name="name" class="w-full rounded-md border border-outline-variant/50 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 bg-surface px-4 py-3" placeholder="Nama Lengkap" type="text" required />
            </div>
            <div>
                <select name="attending" class="w-full rounded-md border border-outline-variant/50 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 bg-surface text-on-surface-variant px-4 py-3" required>
                    <option value="1">Hadir</option>
                    <option value="2">Tidak Hadir</option>
                    <option value="3">Masih Ragu</option>
                </select>
            </div>
            <div>
                <textarea name="message" class="w-full rounded-md border border-outline-variant/50 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 bg-surface px-4 py-3" placeholder="Tulis doa & ucapan..." rows="4" required></textarea>
            </div>
            <button id="rsvpButton" class="w-full border border-primary text-primary px-6 py-3 rounded-md font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary/5 transition-colors" type="submit">
                <span id="buttonText">Kirim Ucapan</span>
                <svg id="buttonSpinner" class="animate-spin hidden inline-block ml-2" style="width:18px;height:18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </button>
        </form>
    </div>

    <!-- Status Message -->
    <div id="rsvpMessage" class="text-center mb-4 text-sm font-bold hidden"></div>

    <!-- RSVP List -->
    <div class="text-center bg-surface p-6 rounded-xl shadow-sm border border-outline-variant/30 fade-in">
        <h3 class="font-body-lg text-body-lg text-primary font-semibold mb-4">Tinggalkan kami doa terbaik untuk momen bahagia kami</h3>
        <div id="rsvpList" class="rsvp-list text-left max-h-[400px] overflow-y-auto" data-url="{{ route('rsvp.list', $invitation) }}">
            <!-- List loaded via JS -->
        </div>
        <p class="font-label-sm text-label-sm text-outline mt-4">({{ $invitation->rsvps->count() }} Ucapan)</p>
    </div>

    @if($invitation->rsvp_whatsapp)
    <div class="text-center mt-6 fade-in">
        <a href="https://wa.me/{{ $invitation->rsvp_whatsapp }}?text=Halo,%20saya%20ingin%20konfirmasi%20RSVP%20untuk%20undangan%20pernikahan." target="_blank" class="inline-flex items-center gap-2 bg-[#22c55e] text-white px-6 py-3 rounded-full font-label-sm text-label-sm hover:bg-[#16a34a] transition-colors">
            <span class="material-symbols-outlined" style="font-size:18px;">chat</span> Konfirmasi via WhatsApp
        </a>
    </div>
    @endif
</section>
@endif
