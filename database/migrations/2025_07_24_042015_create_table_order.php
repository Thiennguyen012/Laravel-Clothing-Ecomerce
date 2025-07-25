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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // null nếu là khách vãng lai
            $table->string('session_id')->nullable(); // session của khách vãng lai

            // Thông tin khách hàng (bắt buộc cho cả user và guest)
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->text('shipping_address');

            // Thông tin đơn hàng
            $table->decimal('subtotal', 10, 2); // Tổng tiền hàng
            $table->decimal('shipping_fee', 10, 2)->default(0); // Phí vận chuyển
            $table->decimal('total', 10, 2); // Tổng thanh toán

            // Trạng thái và thanh toán
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['cod', 'bank_transfer', 'momo', 'vnpay'])->default('cod');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');

            // Ghi chú
            $table->text('notes')->nullable();

            $table->timestamps();

            // Quan hệ khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Index để tăng performance
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
