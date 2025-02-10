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
        Schema::create('customizablecategory', function (Blueprint $table) {
            $table->id('customizeCategoryID');
            $table->foreignId('productID')->constrained('product', 'productID')->onDelete('cascade');
            $table->string('name');
            $table->string('status');
            $table->string('sort');
            $table->boolean('singleChoose');
            $table->boolean('isRequired');
            $table->timestamps();
        });

        Schema::create('customizableoptions', function (Blueprint $table) {
            $table->id('customizeOptionsID');
            $table->foreignId('customizeCategoryID')->constrained('customizablecategory', 'customizeCategoryID')->onDelete('cascade');
            $table->string('name');
            $table->integer('maxAmount');
            $table->string('status');
            $table->string('sort');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customizablecategory');
        Schema::dropIfExists('customizableoptions');
    }
};
