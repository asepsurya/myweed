<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

<x-mail::panel>
    <h1 style="margin-top: 0; color: #18181b; font-size: 22px; font-weight: 600;">
        Verify Your Email Address
    </h1>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-bottom: 0;">
        Hello {{ $name }},
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        Thank you for signing up with <strong>{{ config('app.name') }}</strong>. Please verify your email address by clicking the button below.
        This step helps us keep your account secure.
    </p>
    <p style="font-size: 14px; color: #71717a; margin-top: 16px; margin-bottom: 0;">
        If you did not create an account, no further action is required.
    </p>
</x-mail::panel>

<x-mail::button :url="$verificationUrl" color="success">
    Verify Email Address
</x-mail::button>

<x-slot:footer>
<x-mail::footer>
    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    <br>
    <a href="{{ config('app.url') }}" style="color: #a1a1aa;">{{ config('app.url') }}</a>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
