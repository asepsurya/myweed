<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $invitation->bride_name }} & {{ $invitation->groom_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')
</head>
<body class="bg-[#faf7f2] text-gray-800 font-serif">

@foreach ($invitation->template->sections as $section)
    @includeIf('templates.elegant.sections.' . $section)
@endforeach

@include('templates.elegant.sections.music')

</body>
</html>
