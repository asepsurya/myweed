<section class="min-h-screen flex flex-col justify-center items-center text-center px-6 bg-cover bg-center"
         style="background-image:url('/images/bg-elegant.jpg')">
    <h1 class="text-4xl md:text-6xl tracking-widest mb-4">
        {{ $invitation->bride_name }} <br>&<br> {{ $invitation->groom_name }}
    </h1>
    <p class="text-lg">{{ \Carbon\Carbon::parse($invitation->wedding_date)->translatedFormat('d F Y') }}</p>
</section>
