<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VacanciesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'job_title' => fake()->name(),
            'job_group' => rand(),
            'user_id' => rand(),
            'city' => rand(),
            'company_name' => fake()->name(),
            'description' => fake()->name(),
            'remember_token' => Str::random(10),
        ];
    }
}
