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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('voucherID');
            $table->string('code');
            $table->string('type');
            $table->string('singleUse');
            $table->string('usage');
            $table->decimal('value', 8, 2);
            $table->dateTime('startedOn');
            $table->dateTime('expiredOn');
            $table->integer('usedCount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
