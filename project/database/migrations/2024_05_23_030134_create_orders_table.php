<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

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
            $table->enum('status', ['WAIT', 'PENDING', 'DELIVERING', 'DELIVERED', 'CANCELLED', 'UNACCEPTED'])->default('WAIT');
            $table->string('address')->nullable();
            $table->integer('total');
            $table->timestamp('delivery_date')->default(now()->addWeek());
            $table->timestamp('delivered_at')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->integer('ship')->default(0);
            $table->integer('grand_total')->default(0);
            $table->foreignId('bank_id')->nullable()->constrained('bank_accounts')->onUpdate('cascade')->onDelete('cascade');
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
