      <!-- COUNTDOWN -->
            <div class="bg-primary/10 p-6  text-center animate-on-scroll px-6">
                <h2 class="font-serif text-2xl text-primary mb-4">Menghitung Hari</h2>
                <div class="grid grid-cols-4 gap-2" id="countdown">
                    <div>
                        <p id="days" class="text-2xl font-bold text-primary">0</p>
                        <p class="text-xs">Hari</p>
                    </div>
                    <div>
                        <p id="hours" class="text-2xl font-bold text-primary">0</p>
                        <p class="text-xs">Jam</p>
                    </div>
                    <div>
                        <p id="minutes" class="text-2xl font-bold text-primary">0</p>
                        <p class="text-xs">Menit</p>
                    </div>
                    <div>
                        <p id="seconds" class="text-2xl font-bold text-primary">0</p>
                        <p class="text-xs">Detik</p>
                    </div>
                </div>
            </div>
            <!-- LOCATION -->
            <div class="text-center animate-on-scroll px-6">
                <h2 class="font-serif text-2xl text-primary mb-6">Lokasi & Acara</h2>

                <!-- AKAD NIKAH -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="font-serif text-lg text-primary mb-3">Akad Nikah</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-600 mb-3">Pukul {{ $invitation->akad_time }}</p>
                    <p class="text-sm text-gray-600 mb-3">Tempat {{ $invitation->akad_location }}</p>
                        <a href="{{ $invitation->akad_maps }}" target="_blank"
                            class="inline-block bg-primary text-white px-6 py-2 rounded-full text-sm">
                        Buka Maps
                    </a>
                </div>

                <!-- RESEPSI -->
                <div>
                    <h3 class="font-serif text-lg text-primary mb-3">Resepsi</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-600 mb-3">Pukul {{ $invitation->resepsi_time }}</p>
                    <p class="text-sm text-gray-600 mb-3">Tempat {{ $invitation->resepsi_location }}</p>
                    <a href="{{ $invitation->resepsi_maps }}" target="_blank"
                        class="inline-block bg-primary text-white px-6 py-2 rounded-full text-sm">
                        Buka Maps
                    </a>
                </div>
            </div>
            <div class="relative h-[420px] w-full bg-cover bg-center flex items-center justify-center text-center"
                style="background-image: url('https://picsum.photos/1080/1920?random=10');">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/50"></div>

                <!-- Content -->
                <div class="relative z-10 max-w-md text-white px-6">
                    <p class="italic font-serif text-lg leading-relaxed mb-3">
                        "Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan
                        pasangan untukmu agar kamu merasa tentram."
                    </p>

                    <p class="text-sm opacity-80">
                        (QS. Ar-Rum : 21)
                    </p>
                </div>
            </div>

