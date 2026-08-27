<?php

namespace Database\Factories;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionPlanFactory extends Factory
{
    protected $model = SubscriptionPlan::class;

    public function definition(): array
    {
        return [
            'name' => 'Premium Plan',
            'slug' => 'premium',
            'price' => 99000,
            'duration' => 30,
            'description' => 'Premium subscription plan',
            'is_free' => false,
            'features' => ['unlimited_invitations' => true, 'gallery_limit' => 50],
            'invitation_limit' => 10,
        ];
    }
}
