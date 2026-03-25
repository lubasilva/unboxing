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
        // Criar usuário admin sem duplicar em re-seeds.
        User::updateOrCreate(
            ['email' => 'admin@unboxing.com.br'],
            [
                'name' => 'Admin Unboxing',
                'password' => bcrypt('password'),
            ]
        );

        // Chamar outros seeders
        $this->call([
            SettingsSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
