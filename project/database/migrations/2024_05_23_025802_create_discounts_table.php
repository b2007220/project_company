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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->float('discount')->default(0);
            $table->integer('amount')->default(0);
            $table->timestamp('expired_at')->default(now()->addMonth());
            $table->boolean('is_active')->default(true);
            $table->string('code')->unique();
            $table->string('type')->default('ORDER');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
