<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Hashing\BcryptHasher;
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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => (new BcryptHasher())->make('testpassword'),
            'remember_token' => Str::random(10),
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (web)',
            'province' => 'ontario on',
            'city' => 'toronto',
            'postal_code' => 'M5V0H9',
            'year_of_entry' => '2005-01-01',
            'nigerian_identity' => 'igbo',
            'gender' => 'man',
            'is_admin' => null,
            'topics' => json_encode(["music", "sports", "technology", "poetry"])
        ];
    }
}
