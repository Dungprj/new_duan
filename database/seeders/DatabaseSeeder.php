<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'roles' => 'admin'
        // ]);
        // User::factory()->createMany([
        //     [
        //         'name' => 'dung',
        //         'email' => 'dung@gmail.com',
        //         'roles' => 'user'
        //     ],
        //     [
        //         'name' => 'duan',
        //         'email' => 'duan@gmail.com',
        //         'roles' => 'author'
        //     ]
        // ]);


        $this->call(UsersTableSeeder::class);
    }
}
