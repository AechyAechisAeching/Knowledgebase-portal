<?php
namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Project;
use App\Models\Workspace;
use App\Models\Category;
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
    

        

        DB::table('users')->insert([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'Admin@gmail.com',
            'address' => 'Kyano',
            'company' => 'Kyano Digital',
            'phone_number' => '053853833',
            'password' => Hash::make('Admin@password'),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);


        User::factory()
        ->count(4)
        ->create();        
        
        Workspace::factory()
        ->count(8)
        ->create();
        
        Category::factory()
        ->count(7)
        ->create();

        Project::factory()
        ->count(6)
        ->create();
        
        Article::factory()
        ->count(9)
        ->create();
        
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



    }
}