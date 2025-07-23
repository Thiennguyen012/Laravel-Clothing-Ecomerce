<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = [
            // Variants cho Áo thun cổ tròn Basic (product_id = 1)
            [
                'product_id' => 1,
                'sku' => 'AO-THUN-BASIC-RED-S',
                'color' => 'Đỏ',
                'size' => 'S',
                'price' => 150000.00,
                'compare_at_price' => 200000.00,
                'quantity' => 50,
                'is_active' => true,
                'images' => 'variants/ao-thun-basic-red-s.jpg',
                'description' => 'Áo thun basic màu đỏ size S',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 1,
                'sku' => 'AO-THUN-BASIC-RED-M',
                'color' => 'Đỏ',
                'size' => 'M',
                'price' => 150000.00,
                'compare_at_price' => 200000.00,
                'quantity' => 75,
                'is_active' => true,
                'images' => 'variants/ao-thun-basic-red-m.jpg',
                'description' => 'Áo thun basic màu đỏ size M',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 1,
                'sku' => 'AO-THUN-BASIC-BLUE-S',
                'color' => 'Xanh',
                'size' => 'S',
                'price' => 150000.00,
                'compare_at_price' => 200000.00,
                'quantity' => 30,
                'is_active' => true,
                'images' => 'variants/ao-thun-basic-blue-s.jpg',
                'description' => 'Áo thun basic màu xanh size S',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 1,
                'sku' => 'AO-THUN-BASIC-BLUE-M',
                'color' => 'Xanh',
                'size' => 'M',
                'price' => 150000.00,
                'compare_at_price' => 200000.00,
                'quantity' => 40,
                'is_active' => true,
                'images' => 'variants/ao-thun-basic-blue-m.jpg',
                'description' => 'Áo thun basic màu xanh size M',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Variants cho Quần jean slim fit (product_id = 5)
            [
                'product_id' => 5,
                'sku' => 'QUAN-JEAN-SLIM-BLACK-29',
                'color' => 'Đen',
                'size' => '29',
                'price' => 450000.00,
                'compare_at_price' => 600000.00,
                'quantity' => 20,
                'is_active' => true,
                'images' => 'variants/quan-jean-slim-black-29.jpg',
                'description' => 'Quần jean slim fit màu đen size 29',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 5,
                'sku' => 'QUAN-JEAN-SLIM-BLACK-30',
                'color' => 'Đen',
                'size' => '30',
                'price' => 450000.00,
                'compare_at_price' => 600000.00,
                'quantity' => 35,
                'is_active' => true,
                'images' => 'variants/quan-jean-slim-black-30.jpg',
                'description' => 'Quần jean slim fit màu đen size 30',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 5,
                'sku' => 'QUAN-JEAN-SLIM-BLUE-29',
                'color' => 'Xanh nhạt',
                'size' => '29',
                'price' => 450000.00,
                'compare_at_price' => 600000.00,
                'quantity' => 25,
                'is_active' => true,
                'images' => 'variants/quan-jean-slim-blue-29.jpg',
                'description' => 'Quần jean slim fit màu xanh nhạt size 29',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Variants cho Đầm midi hoa nhí (product_id = 7)
            [
                'product_id' => 7,
                'sku' => 'DAM-MIDI-FLORAL-S',
                'color' => 'Hoa nhí',
                'size' => 'S',
                'price' => 320000.00,
                'compare_at_price' => 450000.00,
                'quantity' => 15,
                'is_active' => true,
                'images' => 'variants/dam-midi-floral-s.jpg',
                'description' => 'Đầm midi họa tiết hoa nhí size S',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 7,
                'sku' => 'DAM-MIDI-FLORAL-M',
                'color' => 'Hoa nhí',
                'size' => 'M',
                'price' => 320000.00,
                'compare_at_price' => 450000.00,
                'quantity' => 22,
                'is_active' => true,
                'images' => 'variants/dam-midi-floral-m.jpg',
                'description' => 'Đầm midi họa tiết hoa nhí size M',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('variants')->insert($variants);
    }
}
