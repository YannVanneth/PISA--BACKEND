<?php

namespace Database\Factories\User;

use App\Models\User\UserProfileModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = UserProfileModel::class;
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'image_url' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
            'provider' => $this->faker->randomElement(['facebook', 'google']),
            'phone_number' => $this->faker->phoneNumber,
            'is_verified' => $this->faker->boolean,
            'otp_code' => $this->faker->numberBetween(1000, 9999),
            'otp_code_expire_at' => $this->faker->dateTime,
        ];
    }
}
