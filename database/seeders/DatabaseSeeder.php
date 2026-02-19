<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Project;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders. 
     */
    public function run(): void
    { 
        
        /** 
         * Run the database factories
        */
        /* ------------------------------------ */
    
        User::factory()
        ->count(10)
        ->create();

        

        DB::table('users')->insert([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'Admin@gmail.com',
            'password' => Hash::make('Admin@password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            'name' => 'Tech',
            'slug' => 'tech',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Project::factory()
        ->count(5)
        ->create();


        DB::table('projects')-> insert([
            'projectname' => 'api laravel',
            'description' => 'api for app',
            'user_id' => 1,
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        

        
         DB::table('tags')->insert([
            [
                'name' => 'personal',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'php',
                'created_at' => now(),
                'updated_at' => now(),
                ],
        ]);



        DB::table('articles')->insert([
            [
                'title' => 'First test article',
                'content' => 'This is test content for article one.',
                'summary' => 'Project summary in short',
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'published',
                'visibility' => 'public',
                'category_id' => 1
                
            ],

            [
                'title' => 'Second test article',
                'content' => 'This is test content for article two.', 
                'summary' => 'Project summary in short',
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'published',
                'visibility' => 'public',
                'category_id' => 1
            ],
        ]);
    }
}