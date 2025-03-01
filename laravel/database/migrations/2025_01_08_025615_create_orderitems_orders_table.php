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
            $table->id('orderID');
            $table->foreignId('userID')->constrained('users', 'userID')->onDelete('cascade');
            $table->integer('tableNo');
            $table->string('status');
            $table->decimal('totalAmount', 9,2);
            $table->timestamps();
        });

        Schema::create('orderitems', function (Blueprint $table) {
            $table->id('orderItemID');
            $table->foreignId('productID')->constrained('product', 'productID')->onDelete('cascade');
            $table->foreignId('orderID')->constrained('orders', 'orderID')->onDelete('cascade');
            $table->integer('quantity');
            $table->json('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderitems');
        Schema::dropIfExists('orders');
    }
};
