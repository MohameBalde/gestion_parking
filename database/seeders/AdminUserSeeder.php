<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'balde8307@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
            'is_active' => true,
            'is_approved' => true,
            'email_verified_at' => now(),
        ]);
    }
}
