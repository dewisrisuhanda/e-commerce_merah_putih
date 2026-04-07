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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('midtrans_order_id', 100)->unique();      // dikirim ke Midtrans
            $table->string('midtrans_transaction_id', 100)->nullable(); // dari response Midtrans
            $table->string('snap_token', 255)->nullable();            // untuk Snap UI
            $table->string('payment_type', 50)->nullable();           // "bank_transfer", "qris", dll
            $table->decimal('gross_amount', 12, 2);
            $table->enum('status', [
                'pending',
                'settlement', // lunas
                'expire',
                'cancel',
                'deny',
                'refund',
            ])->default('pending');
            $table->json('midtrans_response')->nullable();            // raw response Midtrans
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
