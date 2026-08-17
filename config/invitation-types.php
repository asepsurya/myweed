<?php

return [

    'default' => 'wedding',

    'types' => [
        'wedding' => [
            'label' => 'Pernikahan',
            'icon' => 'bi-heart-fill',
            'color' => '#e63946',
            'description' => 'Undangan pernikahan untuk pengajuan akad dan resepsi.',
            'has_partner' => true,
            'fields' => [
                'groom_name',
                'groom_nickname',
                'groom_father_name',
                'groom_mother_name',
                'bride_name',
                'bride_nickname',
                'bride_father_name',
                'bride_mother_name',
                'wedding_date',
                'akad_location',
                'akad_time',
                'resepsi_location',
                'resepsi_time',
            ],
            'tabs' => ['theme', 'groom', 'bride', 'event', 'gallery', 'music', 'rsvp', 'gift', 'story', 'cover'],
        ],

        'graduation' => [
            'label' => 'Wisuda',
            'icon' => 'bi-mortarboard',
            'color' => '#6c4ab6',
            'description' => 'Rayakan pencapaian kelulusan dengan undangan wisuda yang penuh kebanggaan.',
            'has_partner' => false,
            'fields' => [
                'graduate_name',
                'graduate_degree',
                'graduation_date',
                'graduation_location',
                'graduation_time',
                'university',
            ],
            'tabs' => ['theme', 'graduate', 'event', 'gallery', 'rsvp', 'cover'],
        ],

        'birthday' => [
            'label' => 'Ultah',
            'icon' => 'bi-cake',
            'color' => '#f77f07',
            'description' => 'Undangan perayaan ulang tahun untuk momen spesial.',
            'has_partner' => false,
            'fields' => [
                'celebrant_name',
                'celebrant_age',
                'birthday_date',
                'birthday_time',
                'birthday_location',
            ],
            'tabs' => ['theme', 'celebrant', 'event', 'gallery', 'rsvp', 'cover'],
        ],

        'aqiqah' => [
            'label' => 'Aqiqah',
            'icon' => 'bi-egg-fried',
            'color' => '#2a9d8f',
            'description' => 'Sambut anak baru dengan seserahan aqiqah yang bahagia.',
            'has_partner' => false,
            'fields' => [
                'child_name',
                'child_gender',
                'child_birth_date',
                'child_parent_name',
                'child_grandfather_name',
                'event_date',
                'event_location',
                'event_time',
            ],
            'tabs' => ['theme', 'child', 'event', 'gallery', 'music', 'rsvp', 'gift', 'cover'],
        ],

            'tasyakuran' => [
                'label' => 'Tasyakuran',
                'icon' => 'bi-hands-holding-heart',
                'color' => '#2a9d8f',
                'description' => 'Syukur dan berbagi kebahagiaan atas berkat dan karunia yang diterima.',
                'has_partner' => false,
                'fields' => [
                    'host_name',
                    'event_date',
                    'event_location',
                    'event_time',
                    'occasion',
                ],
                'tabs' => ['theme', 'host', 'event', 'gallery', 'rsvp', 'cover'],
            ],

        'hajj' => [
            'label' => 'Haji',
            'icon' => 'bi-airplane-engines',
            'color' => '#264653',
            'description' => 'Bagikan kabar keberangkatan dan kedatangan ibadah haji.',
            'has_partner' => false,
            'fields' => [
                'traveler_name',
                'traveler_group',
                'departure_date',
                'return_date',
                'departure_city',
                'destination',
            ],
            'tabs' => ['theme', 'traveler', 'schedule', 'gallery', 'rsvp', 'cover'],
        ],

        'umroh' => [
            'label' => 'Umroh',
            'icon' => 'bi-mosque',
            'color' => '#1a535c',
            'description' => 'Undangan atau pengumuman perjalanan ibadah umroh.',
            'has_partner' => false,
            'fields' => [
                'traveler_name',
                'traveler_group',
                'departure_date',
                'return_date',
                'departure_city',
            ],
            'tabs' => ['theme', 'traveler', 'schedule', 'gallery', 'rsvp', 'cover'],
        ],
    ],

    'type_field_map' => [
        'wedding' => [
            'groom_name' => 'groom_name',
            'bride_name' => 'bride_name',
        ],
        'graduation' => [
            'graduate_name' => 'custom_data.graduate_name',
            'graduate_degree' => 'custom_data.graduate_degree',
            'graduation_date' => 'custom_data.graduation_date',
            'graduation_location' => 'custom_data.graduation_location',
            'graduation_time' => 'custom_data.graduation_time',
            'university' => 'custom_data.university',
        ],
        'birthday' => [
            'celebrant_name' => 'custom_data.celebrant_name',
            'celebrant_age' => 'custom_data.celebrant_age',
            'birthday_date' => 'custom_data.birthday_date',
            'birthday_time' => 'custom_data.birthday_time',
            'birthday_location' => 'custom_data.birthday_location',
        ],
        'aqiqah' => [
            'child_name' => 'custom_data.child_name',
            'child_gender' => 'custom_data.child_gender',
            'child_birth_date' => 'custom_data.child_birth_date',
            'child_parent_name' => 'custom_data.child_parent_name',
            'child_grandfather_name' => 'custom_data.child_grandfather_name',
        ],
        'tasyakuran' => [
            'host_name' => 'custom_data.host_name',
            'event_date' => 'custom_data.event_date',
            'event_location' => 'custom_data.event_location',
            'event_time' => 'custom_data.event_time',
            'occasion' => 'custom_data.occasion',
        ],
        'hajj' => [
            'traveler_name' => 'custom_data.traveler_name',
            'traveler_group' => 'custom_data.traveler_group',
            'departure_date' => 'custom_data.departure_date',
            'return_date' => 'custom_data.return_date',
            'departure_city' => 'custom_data.departure_city',
            'destination' => 'custom_data.destination',
        ],
        'umroh' => [
            'traveler_name' => 'custom_data.traveler_name',
            'traveler_group' => 'custom_data.traveler_group',
            'departure_date' => 'custom_data.departure_date',
            'return_date' => 'custom_data.return_date',
            'departure_city' => 'custom_data.departure_city',
        ],
    ],

    'couple_types' => ['wedding'],
];