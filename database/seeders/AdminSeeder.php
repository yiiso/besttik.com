<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => '管理员',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'is_active' => true,
        ]);
    }
}