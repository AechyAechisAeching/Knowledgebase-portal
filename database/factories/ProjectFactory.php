<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Category;
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
    $projectname = $this->faker->sentence();
    return [
        'projectname' => $projectname,
        'description' => $this->faker->paragraph(),
        'slug' => Str::slug($projectname),
        'category_id' => Category::inRandomOrder()->first()->id,
        'user_id' => User::inRandomOrder()->first()->id,
    ];
}
}

