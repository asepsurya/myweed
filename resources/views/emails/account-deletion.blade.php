<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

<x-mail::panel>
    <h1 style="margin-top: 0; color: #18181b; font-size: 22px; font-weight: 600;">
        Confirm Account Deletion
    </h1>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-bottom: 0;">
        Hello {{ $name }},
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        You have requested to permanently delete your <strong>{{ config('app.name') }}</strong> account. This action cannot be undone.
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        Please confirm by clicking the button below. All your data, including settings and history, will be permanently removed.
    </p>
    <p style="font-size: 14px; color: #71717a; margin-top: 16px; margin-bottom: 0;">
        If you change your mind, simply do not click the button and your account will remain unaffected.
    </p>
</x-mail::panel>

<x-mail::button :url="$confirmUrl" color="error">
    Delete Account
</x-mail::button>

<x-mail::subcopy>
    <p style="font-size: 14px; color: #71717a; margin-top: 0;">
        This link will expire in {{ $expiration }} minutes.
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
