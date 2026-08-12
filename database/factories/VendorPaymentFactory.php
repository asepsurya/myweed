<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\User;
use App\Models\VendorPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorPaymentFactory extends Factory
{
    protected $model = VendorPayment::class;

    public function definition(): array
    {
        return [
            'invitation_id' => Invitation::factory(),
            'budget_category_id' => null,
            'user_id' => User::factory(),
            'vendor_name' => fake()->company(),
            'vendor_contact' => fake()->phoneNumber(),
            'amount' => fake()->numberBetween(1000000, 50000000),
            'currency' => 'IDR',
            'scheduled_date' => fake()->dateTimeBetween('-10 days', '+30 days'),
            'due_date' => fake()->dateTimeBetween('+30 days', '+60 days'),
            'paid_at' => fake()->boolean(50) ? now() : null,
            'status' => fake()->randomElement(['scheduled', 'paid', 'cancelled']),
            'notes' => fake()->sentence,
        ];
    }
}
