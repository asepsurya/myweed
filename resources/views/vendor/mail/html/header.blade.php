@props(['url'])
<tr>
    <td class="header" style="padding: 2.5rem 2.25rem 0; text-align: center;">
        <a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
            @if (trim($slot) === 'Laravel')
            <img src="https://laravel.com/img/notification-logo-v2.1.png" class="logo" alt="Laravel Logo">
            @else
            <span class="email-brand" style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.4rem; font-weight: 700; color: #1B2A4A; letter-spacing: -0.01em;">{{ $slot }}</span>
            @endif
        </a>
    </td>
</tr>
