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
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột avg_rating với decimal(2,1) để lưu rating từ 0.0 đến 5.0
            $table->decimal('avg_rating', 2, 1)->default(0.0)->after('description');

            // Thêm cột total_ratings để đếm số lượng đánh giá
            $table->unsignedInteger('total_ratings')->default(0)->after('avg_rating');

            // Index cho performance khi sort theo rating
            $table->index('avg_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['avg_rating']);
            $table->dropColumn(['avg_rating', 'total_ratings']);
        });
    }
};
