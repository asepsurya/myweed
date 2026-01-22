<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invitationId = 1; // pastikan invitation ini ada

        $gifts = [
            [
                'bank'   => 'BCA',
                'number' => '1234567890',
                'name'   => 'Agung Hermawan',
                'qr'     => 'invitations/1/gift/bca.webp',
            ],
            [
                'bank'   => 'Mandiri',
                'number' => '9876543210',
                'name'   => 'Siti Maimunah',
                'qr'     => 'invitations/1/gift/mandiri.webp',
            ],
            [
                'bank'   => 'OVO',
                'number' => '081234567890',
                'name'   => 'Agung & Siti',
                'qr'     => null,
            ],
            [
                'bank'   => 'GoPay',
                'number' => '081298765432',
                'name'   => 'Agung Hermawan',
                'qr'     => null,
            ],
        ];

        foreach ($gifts as $gift) {
            Gift::create([
                'invitation_id' => $invitationId,
                'bank'   => $gift['bank'],
                'number' => $gift['number'],
                'name'   => $gift['name'],
                'qr'     => $gift['qr'],
            ]);
        }
    }
}
