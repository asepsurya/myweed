
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('theme.title','Undangan Pernikahan') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-[#0F0F0F] text-[#D4AF37]">

@include('sections.hero')
@include('sections.couple')
@include('sections.event')
@include('sections.gallery')
@include('sections.rsvp')
@include('sections.music')

</body>
</html>
