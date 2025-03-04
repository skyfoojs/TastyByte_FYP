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
        // Create the 'categories' table
        Schema::create('category', function (Blueprint $table) {
            $table->id('categoryID');
            $table->string('name');
            $table->string('status');
            $table->string('sort');
            $table->timestamps();
        });

        // Create the 'products' table
        Schema::create('product', function (Blueprint $table) {
            $table->id('productID');
            $table->foreignId('categoryID')->constrained('category', 'categoryID')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->text('description')->nullable();
            $table->string('status');
            $table->string('image')->nullable();
            $table->timestamps();

            // Foreign key constraint
            //$table->foreign('categoryID')->references('categoryID')->on('category')->onDelete('cascade');
        });

        // Create the 'inventory' table
        Schema::create('inventory', function (Blueprint $table) {
            $table->id('inventoryID');
            $table->integer('stockLevel');
            $table->integer('minLevel');
            $table->string('name');
            $table->timestamps();

            // Foreign key constraint
            // $table->foreign('productID')->references('productID')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
        Schema::dropIfExists('product');
        Schema::dropIfExists('category');
    }
};
