<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'pixabay' => [
        'key' => env('PIXABAY_API_KEY'),
    ],

    'fonnte' => [
        'api_key' => env('FONTE_API_KEY'),
        'api_url' => env('FONTE_API_URL', 'https://api.fonnte.com/send'),
    ],

    'admin_whatsapp' => env('ADMIN_WHATSAPP', '087731402487'),

    'facebook' => [
        'pixel_id' => env('FACEBOOK_PIXEL_ID'),
    ],

    'socials' => [
        'facebook' => env('SOCIAL_FACEBOOK_URL', 'https://www.facebook.com/ruangundang'),
        'instagram' => env('SOCIAL_INSTAGRAM_URL', 'https://www.instagram.com/ruangundang'),
        'tiktok' => env('SOCIAL_TIKTOK_URL', 'https://www.tiktok.com/@ruangundang'),
        'youtube' => env('SOCIAL_YOUTUBE_URL', 'https://www.youtube.com/@ruangundang'),
        'x' => env('SOCIAL_X_URL', 'https://x.com/ruangundang'),
        'linkedin' => env('SOCIAL_LINKEDIN_URL', 'https://www.linkedin.com/company/ruangundang'),
        'tokopedia' => env('SOCIAL_TOKOPEDIA_URL', 'https://tokopedia.com'),
        'shopee' => env('SOCIAL_SHOPEE_URL', 'https://shopee.co.id'),
    ],

];
