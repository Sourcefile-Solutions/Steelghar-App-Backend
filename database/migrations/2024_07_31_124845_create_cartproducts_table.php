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
        Schema::create('cartproducts', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_id');
            $table->integer('product_id');
            $table->integer('brand_id')->nullable();
            $table->integer('product_attribute_id')->nullable();
            $table->string('length')->nullable();
            $table->string('no_of_sheet')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartproducts');
    }
};
