  <!-- QUOTE -->
            <div class="text-center animate-on-scroll px-6">
                <i class="ti ti-flower"></i>

                <div class="mb-2"> السلام عليكم ورحمة الله وبركاته</div>
                Segala Puji Bagi Allah SWT yang telah menjadikan hambanya hidup berpasang-pasangan. Dengan memohon
                Ridho, Rahmat, dan Berkah Allah SWT, kami bermaksud untuk mengundang Saudara/i dalam acara pernikahan
                yang kami selenggarakan.

            </div>


<!-- MEMPELAI -->
            <div class="text-center animate-on-scroll px-6">
                <h2 class="font-serif text-3xl text-primary mb-6">Mempelai</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <img src="/storage/{{ $invitation->foto_pria }}" class="w-28 h-28 rounded-full mx-auto shadow">
                        <h3 class="font-serif mt-3">{{ $invitation->groom_name }} </h3>
                        <p class="text-xs text-gray-500">Putra Bpk {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}</p>
                        <a href="https://instagram.com" target="_blank" class="text-primary hover:text-primary/80">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                    </div>
                    <div>
                        <img src="/storage/{{ $invitation->foto_wanita }}" class="w-28 h-28 rounded-full mx-auto shadow">
                        <h3 class="font-serif mt-3">{{ $invitation->bride_name }}</h3>
                        <p class="text-xs text-gray-500">Putri Bpk {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}</p>
                        <a href="https://instagram.com" target="_blank" class="text-primary hover:text-primary/80">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
