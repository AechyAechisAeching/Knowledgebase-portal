<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */

class ProjectFactory extends Factory
{
        protected $model = project::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'projectname' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'category_id' => 1,
            'user_id' => User::factory(),
        ];
    }
}
