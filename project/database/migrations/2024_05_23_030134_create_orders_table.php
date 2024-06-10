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
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('payment_type', ['CASH', 'TRANSFER'])->default('CASH');
            $table->enum('status', ['PENDING', 'DELIVERING', 'DELIVERED', 'CANCELLED', 'UNACCEPTED'])->default('PENDING');
            $table->string('address')->nullable();
            $table->integer('total_price');
            $table->timestamp('delivery_date')->default(now()->addWeek());
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
