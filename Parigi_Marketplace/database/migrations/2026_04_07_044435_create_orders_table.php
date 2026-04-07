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
            $table->string('order_number', 100)->unique(); // contoh: INV-20260403-0001
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('shipping_method_id')->constrained('shipping_methods');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->text('address')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', [
                'pending_payment',
                'paid',
                'processing',
                'shipped',
                'completed',
                'canceled',
            ])->default('pending_payment');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
