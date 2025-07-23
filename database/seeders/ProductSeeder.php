<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Áo thun (category_id = 1)
            [
                'product_id' => 1,
                'product_name' => 'Áo thun cổ tròn Basic',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 2,
                'product_name' => 'Áo thun Polo nam',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Áo sơ mi (category_id = 2)
            [
                'product_id' => 3,
                'product_name' => 'Áo sơ mi công sở nam',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 4,
                'product_name' => 'Áo sơ mi kẻ sọc',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Quần jean (category_id = 3)
            [
                'product_id' => 5,
                'product_name' => 'Quần jean slim fit',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 6,
                'product_name' => 'Quần jean nữ ống rộng',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Đầm (category_id = 5)
            [
                'product_id' => 7,
                'product_name' => 'Đầm midi hoa nhí',
                'category_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 8,
                'product_name' => 'Đầm công sở',
                'category_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('products')->insert($products);
    }
}
