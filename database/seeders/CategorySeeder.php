<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_id' => 1,
                'category_name' => 'Áo thun',
                'description' => 'Bộ sưu tập áo thun nam nữ đa dạng kiểu dáng, chất liệu cotton cao cấp',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_id' => 2,
                'category_name' => 'Áo sơ mi',
                'description' => 'Áo sơ mi công sở, casual phong cách hiện đại',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_id' => 3,
                'category_name' => 'Quần jean',
                'description' => 'Quần jean nam nữ form đẹp, chất liệu denim cao cấp',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_id' => 4,
                'category_name' => 'Quần short',
                'description' => 'Quần short thể thao, casual cho mùa hè',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_id' => 5,
                'category_name' => 'Đầm',
                'description' => 'Đầm nữ đa dạng kiểu dáng từ công sở đến dự tiệc',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_id' => 6,
                'category_name' => 'Áo khoác',
                'description' => 'Áo khoác nam nữ phong cách, chất liệu ấm áp',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}
