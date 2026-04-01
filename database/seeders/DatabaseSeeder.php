<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::firstOrCreate(
            ['email' => 'admin@ostex.com'],
            [
                'name' => 'Ostex Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
