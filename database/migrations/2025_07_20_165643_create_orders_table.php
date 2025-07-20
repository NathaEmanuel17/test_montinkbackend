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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'paid', 'shipped', 'delivered', 'canceled'])->default('pending');

            $table->string('zip_code', 10);
            $table->string('address');
            $table->string('number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city');
            $table->string('state');

            $table->decimal('shipping_price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
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
