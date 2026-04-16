<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

       user::first0rCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Test User',
            'password' => bcrypt('password'),
        ]
    );
        $this->call([
            PembimbingSeeder::class,
            ProdukSeeder::class,
        ]);
    }
}
