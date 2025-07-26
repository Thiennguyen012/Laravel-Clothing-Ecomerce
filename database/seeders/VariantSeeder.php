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
            ],
            // variant cho áo khoác bomber (product_id = 9)
            [
                'product_id' => 9,
                'sku' => 'AO-BOMBER-DEN-M',
                'color' => 'Đen',
                'size' => 'M',
                'price' => 400000.00,
                'compare_at_price' => 500000.00,
                'quantity' => 22,
                'is_active' => true,
                'images' => 'variants/ao-bomber-den-m.jpg',
                'description' => 'Áo khoác bomber màu đen size M',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 9,
                'sku' => 'AO-BOMBER-DEN-L',
                'color' => 'Đen',
                'size' => 'M',
                'price' => 350000.00,
                'compare_at_price' => 500000.00,
                'quantity' => 22,
                'is_active' => true,
                'images' => 'variants/ao-bomber-den-l.jpg',
                'description' => 'Áo khoác bomber màu đen size L',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 9,
                'sku' => 'AO-BOMBER-TRANG-M',
                'color' => 'Trắng',
                'size' => 'M',
                'price' => 400000.00,
                'compare_at_price' => 500000.00,
                'quantity' => 22,
                'is_active' => true,
                'images' => 'variants/ao-bomber-trang-m.jpg',
                'description' => 'Áo khoác bomber màu trắng size M',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 9,
                'sku' => 'AO-BOMBER-TRANG-L',
                'color' => 'Trắng',
                'size' => 'L',
                'price' => 350000.00,
                'compare_at_price' => 500000.00,
                'quantity' => 22,
                'is_active' => true,
                'images' => 'variants/ao-bomber-trang-l.jpg',
                'description' => 'Áo khoác bomber màu trắng size L',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 9,
                'sku' => 'AO-BOMBER-TRANG-XL',
                'color' => 'Trắng',
                'size' => 'XL',
                'price' => 400000.00,
                'compare_at_price' => 500000.00,
                'quantity' => 22,
                'is_active' => true,
                'images' => 'variants/ao-bomber-trang-xl.jpg',
                'description' => 'Áo khoác bomber màu trắng size XL',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Variants cho áo khoác gió (product_id = 10)
            [
                'product_id' => 10,
                'sku' => 'KHOAC-GIO-XANH-M',
                'color' => 'Xanh navy',
                'size' => 'M',
                'price' => 370000.00,
                'compare_at_price' => 450000.00,
                'quantity' => 12,
                'is_active' => true,
                'images' => 'variants/khoac-gio-xanh-m.jpg',
                'description' => 'Áo khoác gió màu xanh navy size M',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 10,
                'sku' => 'KHOAC-GIO-XAM-L',
                'color' => 'Xám',
                'size' => 'L',
                'price' => 375000.00,
                'compare_at_price' => 450000.00,
                'quantity' => 10,
                'is_active' => true,
                'images' => 'variants/khoac-gio-xam-l.jpg',
                'description' => 'Áo khoác gió màu xám size L',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 10,
                'sku' => 'KHOAC-GIO-DEN-XL',
                'color' => 'Đen',
                'size' => 'XL',
                'price' => 380000.00,
                'compare_at_price' => 450000.00,
                'quantity' => 8,
                'is_active' => true,
                'images' => 'variants/khoac-gio-den-xl.jpg',
                'description' => 'Áo khoác gió màu đen size XL',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // mũ lưỡi trai (product_id = 11)
            [
                'product_id' => 11,
                'sku' => 'MU-LUOI-TRAI-DEN-M',
                'color' => 'Đen',
                'size' => 'M',
                'price' => 150000.00,
                'compare_at_price' => 200000.00,
                'quantity' => 50,
                'is_active' => true,
                'images' => 'variants/Mu-luoi-trai-den-m.jpg',
                'description' => 'Mũ lưỡi trai thể thao màu đen',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 11,
                'sku' => 'MU-LUOI-TRAI-DO-M',
                'color' => 'Đỏ',
                'size' => 'M',
                'price' => 150000.00,
                'compare_at_price' => 200000.00,
                'quantity' => 50,
                'is_active' => true,
                'images' => 'variants/Mu-luoi-trai-do-m.jpg',
                'description' => 'Mũ lưỡi trai thể thao màu đỏ',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 11,
                'sku' => 'MU-LUOI-TRAI-XAM-M',
                'color' => 'xám',
                'size' => 'M',
                'price' => 150000.00,
                'compare_at_price' => 200000.00,
                'quantity' => 50,
                'is_active' => true,
                'images' => 'variants/Mu-luoi-trai-xãm-m.jpg',
                'description' => 'Mũ lưỡi trai thể thao màu xám',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // kính râm (product_id = 12)
            [
                'product_id' => 12,
                'sku' => 'KINH-RAM-THOI-TRANG-DEN-NHAM',
                'color' => 'Gọng đen nhám',
                'size' => 'M',
                'price' => 200000.00,
                'compare_at_price' => 250000.00,
                'quantity' => 50,
                'is_active' => true,
                'images' => 'variants/Kinh-ram-thoi-trang-den-nham.jpg',
                'description' => 'Kính râm thời trang gọng đen nhám',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 12,
                'sku' => 'KINH-RAM-THOI-TRANG-DEN-BONG',
                'color' => 'Gọng đen bóng',
                'size' => 'M',
                'price' => 150000.00,
                'compare_at_price' => 200000.00,
                'quantity' => 50,
                'is_active' => true,
                'images' => 'variants/Kinh-ram-thoi-trang-den-bong.jpg',
                'description' => 'Kính râm thời trang gọng đen bóng',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('variants')->insert($variants);
    }
}
