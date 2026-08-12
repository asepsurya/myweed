<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

<x-mail::panel>
    <h1 style="margin-top: 0; color: #18181b; font-size: 22px; font-weight: 600;">
        New Sign-In Detected
    </h1>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-bottom: 0;">
        Hello {{ $name }},
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        A new sign-in was detected on your <strong>{{ config('app.name') }}</strong> account.
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        If this was you, no further action is needed. If you did not sign in, your account may be compromised. Please change your password immediately and contact our support team.
    </p>
</x-mail::panel>

<x-mail::panel>
    <h2 style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #71717a; margin-top: 0; margin-bottom: 12px;">
        Sign-In Details
    </h2>
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">Device</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ $device ?? 'Unknown' }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">Location</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ $location ?? 'Unknown' }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">IP Address</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ $ipAddress ?? 'Unknown' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">Time</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ now()->format('F j, Y g:i A') }}</td>
        </tr>
    </table>
</x-mail::panel>

<x-slot:footer>
<x-mail::footer>
    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    <br>
    <a href="{{ config('app.url') }}" style="color: #a1a1aa;">{{ config('app.url') }}</a>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
