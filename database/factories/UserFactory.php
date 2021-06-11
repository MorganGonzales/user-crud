<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'prefixname' => ['Mr.', 'Mrs.', 'Ms.'][rand(0, 2)],
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->lastName,
            'lastname' => $this->faker->lastName,
            'suffixname' => $this->faker->suffix,
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
        ];
    }
}
