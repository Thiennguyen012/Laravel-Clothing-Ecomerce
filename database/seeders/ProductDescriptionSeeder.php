<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cập nhật description theo tên sản phẩm thực tế từ ProductSeeder
        $descriptions = [
            'Áo thun cổ tròn Basic' => 'Áo thun nam cổ tròn chất liệu cotton 100% thoáng mát, thấm hút mồ hôi tốt. Thiết kế đơn giản, phù hợp cho mọi hoạt động hàng ngày. Có nhiều màu sắc để lựa chọn: trắng, đen, xám, navy. Form áo vừa vặn, không quá rộng hay quá ôm.',

            'Áo thun Polo nam' => 'Áo thun Polo nam chất liệu cotton cao cấp, có cổ bẻ thanh lịch. Thiết kế lịch sự nhưng vẫn năng động, phù hợp cho cả công sở và dạo phố. Form áo vừa vặn, thoáng mát và dễ phối đồ.',

            'Áo sơ mi công sở nam' => 'Áo sơ mi nam công sở chất liệu cotton pha polyester, chống nhăn và dễ ủi. Thiết kế lịch sự, phù hợp cho môi trường công sở và các sự kiện trang trọng. Cổ áo và tay áo được may tỉ mỉ, đường may chắc chắn.',

            'Áo sơ mi kẻ sọc' => 'Áo sơ mi kẻ sọc hiện đại, chất liệu cotton mềm mại và thoáng khí. Họa tiết sọc tinh tế tạo điểm nhấn thời trang. Phù hợp cho các buổi gặp mặt bạn bè hoặc đi làm trong môi trường thoải mái.',

            'Quần jean slim fit' => 'Quần jeans nam slim fit chất liệu denim cao cấp, bền đẹp và không phai màu. Thiết kế ôm vừa phải, tôn dáng và tạo vẻ ngoài năng động. Có túi sau và túi trước tiện dụng. Phù hợp cho đi làm, đi chơi hoặc các hoạt động thường ngày.',

            'Quần jean nữ ống rộng' => 'Quần jean nữ ống rộng theo xu hướng thời trang hiện đại. Chất liệu denim mềm mại, thoải mái khi mặc. Thiết kế ống rộng trendy, tạo phong cách cá tính và năng động cho phái đẹp.',

            'Đầm midi hoa nhí' => 'Đầm midi họa tiết hoa nhí nữ tính và dễ thương. Chất liệu voan mềm mại, thoáng mát. Thiết kế dáng suông vừa vặn, phù hợp cho các buổi dạo phố, đi làm hoặc dự tiệc nhẹ. Tạo vẻ ngoài thanh lịch và nữ tính.',

            'Đầm công sở' => 'Đầm công sở thanh lịch, chất liệu cao cấp chống nhăn. Thiết kế đơn giản nhưng tinh tế, phù hợp cho môi trường công sở chuyên nghiệp. Form đầm ôm vừa vặn, tôn dáng và tạo vẻ ngoài tự tin.',

            'Áo khoác Bomber' => 'Áo khoác bomber dày dặn, kiểu dáng trẻ trung',

            'Áo khoác gió' => 'Áo khoác gió thoáng mát, đa dạng mẫu mã, phù hợp với mọi lứa tuổi',

            'Mũ lưỡi trai thể thao' => 'Mũ lưỡi trai thể thao năng động, phù hợp với những hoạt động ngoài trời',

            'Kính râm thời trang' => 'Kính râm thời trang sang trọng, chất liệu cao cấp'

        ];

        // Cập nhật description cho các sản phẩm hiện có
        foreach ($descriptions as $productName => $description) {
            Product::where('product_name', 'like', '%' . $productName . '%')
                ->update([
                    'description' => $description,
                    'is_active' => true
                ]);
        }
    }
}
