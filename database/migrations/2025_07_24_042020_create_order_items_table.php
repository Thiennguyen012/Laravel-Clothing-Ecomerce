<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('variant_id');

            // Lưu thông tin sản phẩm tại thời điểm đặt hàng (snapshot)
            $table->string('product_name'); // Tên sản phẩm
            $table->string('variant_sku'); // Mã SKU
            $table->string('color')->nullable(); // Màu sắc
            $table->string('size')->nullable(); // Kích thước
            $table->string('product_image')->nullable(); // Hình ảnh sản phẩm

            // Thông tin số lượng và giá
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2); // Giá đơn vị tại thời điểm đặt
            $table->decimal('total_price', 10, 2); // Tổng tiền (quantity * unit_price)

            $table->timestamps();

            // Quan hệ khóa ngoại
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');

            // Index để tăng performance
            $table->index('order_id');
            $table->index('variant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
