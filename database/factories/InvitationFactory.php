<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'template_id' => null,
            'slug' => 'wedding-'.Str::random(8),
            'is_default' => false,
            'status' => 'active',
            'primary_color' => '#0d9488',
            'groom_name' => fake()->name('male'),
            'bride_name' => fake()->name('female'),
            'wedding_date' => fake()->dateTimeBetween('+30 days', '+1 year')->format('Y-m-d'),
            'akad_location' => fake()->sentence(3),
            'akad_time' => '08:00:00',
            'resepsi_location' => fake()->sentence(3),
            'resepsi_time' => '11:00:00',
        ];
    }
}
