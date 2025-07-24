<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo user test
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@laravel-ecommerce.com',
        ]);

        // Chạy các seeders theo thứ tự
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            ProductDescriptionSeeder::class, // Thêm seeder mới
            VariantSeeder::class,
        ]);
    }
}
