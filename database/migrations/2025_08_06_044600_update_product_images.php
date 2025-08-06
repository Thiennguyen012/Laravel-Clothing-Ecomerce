<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $products = [
            1 => 'products/1754455271-22603330_53005775_2048.webp', // Áo thun cổ tròn Basic
            2 => 'products/1753935306-ao-polo-nam.png',             // Áo thun Polo nam
            3 => 'products/1753935410-ao-so-mi.jpg',                // Áo sơ mi công sở nam
            4 => 'products/1753935461-ao-so-mi-ke-soc.jpg',         // Áo sơ mi kẻ sọc
            5 => 'products/1753935505-quan-jeans-slimfit.jpg',      // Quần jeans slim fit
            6 => 'products/1753935572-quan-jeans-nnu-ong-rong.jpg', // Quần jeans ống rộng
            7 => 'products/1753935635-dam-midi-hoa-nhi.webp',       // Đầm midi hoa nhí
            8 => 'products/1754302094-dam-cong-so.webp',            // Đầm công sở
            9 => 'products/1754302210-ao-bomber.webp',              // Áo bomber
            10 => 'products/1754302253-ao-khoac-gio.jpg',           // Áo khoác gió
            11 => 'products/1754302309-mu-luoi-trai-the-thao.png',  // Mũ lưới trai thể thao
            12 => 'products/1754302394-kinh-ram-thoi-trang.png',    // Kính râm thời trang
            13 => 'products/1754302427-vong-tay-thoi-trang.webp'    // Vòng tay thời trang
        ];

        foreach ($products as $id => $image) {
            DB::table('products')
                ->where('product_id', $id)
                ->update(['images' => $image]);
        }
    }

    public function down()
    {
        DB::table('products')->update(['images' => null]);
    }
};
