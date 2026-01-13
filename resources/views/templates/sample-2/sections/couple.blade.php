<section class="py-20 px-6 text-center">
    <h2 class="text-3xl mb-10">Mempelai</h2>

    <div class="grid md:grid-cols-2 gap-10 max-w-4xl mx-auto">
        <div>
            <h3 class="text-2xl">{{ $invitation->bride_name }}</h3>
            <p class="mt-3 text-sm text-gray-600">
                Putri dari Bapak & Ibu
            </p>
        </div>

        <div>
            <h3 class="text-2xl">{{ $invitation->groom_name }}</h3>
            <p class="mt-3 text-sm text-gray-600">
                Putra dari Bapak & Ibu
            </p>
        </div>
    </div>
</section>
