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
        Schema::create('cart_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 191)->unique(); // Session ID duy nhất với length limit
            $table->string('ip_address', 45)->nullable(); // IP address (IPv6 max 45 chars)
            $table->text('user_agent')->nullable(); // User agent có thể rất dài
            $table->timestamp('last_activity')->useCurrent(); // Lần cuối hoạt động với default
            $table->timestamp('expires_at')->nullable(); // Thời gian hết hạn
            $table->timestamps();

            // Index (không cần index session_id vì đã unique)
            $table->index(['expires_at', 'last_activity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_sessions');
    }
};
