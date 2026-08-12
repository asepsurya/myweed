<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

<x-mail::panel>
    <h1 style="margin-top: 0; color: #18181b; font-size: 22px; font-weight: 600;">
        Reset Your Password
    </h1>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-bottom: 0;">
        Hello {{ $name }},
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        We received a request to reset the password for your <strong>{{ config('app.name') }}</strong> account.
        Click the button below to choose a new password.
    </p>
    <p style="font-size: 14px; color: #71717a; margin-top: 16px; margin-bottom: 0;">
        If you did not request this change, you can safely ignore this email — your password will remain unchanged.
    </p>
</x-mail::panel>

<x-mail::button :url="$resetUrl" color="primary">
    Reset Password
</x-mail::button>

<x-mail::panel>
    <h2 style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #71717a; margin-top: 0; margin-bottom: 12px;">
        Details
    </h2>
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">Account</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ $email }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">Requested at</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ now()->format('F j, Y g:i A') }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">IP Address</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ $ip ?? 'N/A' }}</td>
        </tr>
    </table>
</x-mail::panel>

<x-mail::subcopy>
    <p style="font-size: 14px; color: #71717a; margin-top: 0;">
        This password reset link will expire in {{ $expiration }} minutes.
    </p>
</x-mail::subcopy>

<x-slot:footer>
<x-mail::footer>
    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    <br>
    <a href="{{ config('app.url') }}" style="color: #a1a1aa;">{{ config('app.url') }}</a>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
