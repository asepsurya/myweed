<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

<x-mail::panel>
    <h1 style="margin-top: 0; color: #18181b; font-size: 22px; font-weight: 600;">
        Welcome to {{ config('app.name') }}!
    </h1>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-bottom: 0;">
        Hello {{ $name }},
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        Welcome to <strong>{{ config('app.name') }}</strong>! We're excited to have you on board. Your account has been successfully created.
    </p>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 8px;">
        Here are a few things you can do to get started:
    </p>
    <ul style="padding-left: 20px; margin: 0; color: #52525b;">
        <li style="margin-bottom: 8px;">Complete your profile to personalize your experience</li>
        <li style="margin-bottom: 8px;">Explore our features and see what we have to offer</li>
        <li style="margin-bottom: 0;">Reach out to us if you need any help along the way</li>
    </ul>
    <p style="font-size: 16px; line-height: 1.6; color: #52525b; margin-top: 16px; margin-bottom: 0;">
        If you have any questions, our support team is always ready to help.
    </p>
</x-mail::panel>

<x-mail::button :url="$dashboardUrl" color="success">
    Go to Dashboard
</x-mail::button>

<x-mail::panel>
    <h2 style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #71717a; margin-top: 0; margin-bottom: 12px;">
        Account Details
    </h2>
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">Name</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ $name }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">Email</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ $email }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f4f4f5;">
            <td style="padding: 8px 0; font-size: 14px; color: #71717a; width: 40%;">Joined</td>
            <td style="padding: 8px 0; font-size: 14px; color: #18181b; font-weight: 500;">{{ now()->format('F j, Y') }}</td>
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
