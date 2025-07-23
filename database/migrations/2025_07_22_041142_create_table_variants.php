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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');

            // Thuộc tính cơ bản của variant quần áo
            $table->string('sku')->unique(); // Mã SKU unique cho mỗi variant
            $table->string('color')->nullable(); // Màu sắc (Đỏ, Xanh, Vàng...)
            $table->string('size')->nullable(); // Kích thước (S, M, L, XL, XXL...)
            // Giá và tồn kho
            $table->decimal('price', 10, 2); // Giá tối đa 99,999,999.99 VND
            $table->decimal('compare_at_price', 10, 2)->nullable(); // Giá gốc để hiện giảm giá
            $table->integer('quantity')->default(0); // Số lượng tồn kho

            // Trạng thái
            $table->boolean('is_active')->default(true); // Có đang bán không

            // Metadata
            $table->string('images')->nullable(); // Hình ảnh riêng của variant
            $table->text('description')->nullable(); // Mô tả riêng

            $table->timestamps();

            // Foreign key và indexes
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->index(['product_id', 'is_active']);
            $table->index(['color', 'size']);
            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
