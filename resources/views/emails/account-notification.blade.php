<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

<x-mail::panel>
    <h1 style="margin-top: 0; color: #18181b; font-size: 22px; font-weight: 600;">
        {{ $heading ?? 'Account Notification' }}
    </h1>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-bottom: 0;">
        Hello {{ $name }},
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        {!! $message !!}
    </p>
</x-mail::panel>

@isset($action)
<x-mail::button :url="$action['url']" :color="$action['color'] ?? 'primary'">
    {{ $action['label'] ?? 'Take Action' }}
</x-mail::button>
@endisset

@isset($details)
<x-mail::panel>
    <h2 style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #71717a; margin-top: 0; margin-bottom: 12px;">
        Details
    </h2>
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        @foreach($details as $label => $value)
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">{{ $label }}</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ $value }}</td>
        </tr>
        @endforeach
    </table>
</x-mail::panel>
@endisset

<x-slot:footer>
<x-mail::footer>
    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    <br>
    <a href="{{ config('app.url') }}" style="color: #a1a1aa;">{{ config('app.url') }}</a>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
