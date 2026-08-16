<?php

namespace Database\Seeders;

use App\Models\Gift;
use App\Models\Invitation;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invitation = Invitation::find(1);
        if (!$invitation) {
            return;
        }

        $publicId = $invitation->public_id;
        $gifts = [
            [
                'bank' => 'BCA',
                'number' => '1234567890',
                'name' => 'Agung Hermawan',
                'qr' => "invitations/{$publicId}/gift/bca.webp",
            ],
            [
                'bank' => 'Mandiri',
                'number' => '9876543210',
                'name' => 'Siti Maimunah',
                'qr' => "invitations/{$publicId}/gift/mandiri.webp",
            ],
            [
                'bank' => 'OVO',
                'number' => '081234567890',
                'name' => 'Agung & Siti',
                'qr' => null,
            ],
            [
                'bank' => 'GoPay',
                'number' => '081298765432',
                'name' => 'Agung Hermawan',
                'qr' => null,
            ],
        ];

        foreach ($gifts as $gift) {
            Gift::create([
                'invitation_id' => $invitation->id,
                'bank' => $gift['bank'],
                'number' => $gift['number'],
                'name' => $gift['name'],
                'qr' => $gift['qr'],
            ]);
        }
    }
}
