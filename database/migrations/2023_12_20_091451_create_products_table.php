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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('subcategory_id')->nullable();
            $table->string('division_id')->nullable();
            $table->string('subdivision_id')->nullable();
            $table->string('dimension')->nullable();
            $table->string('thickness_id')->nullable();
            $table->string('height_id')->nullable();
            $table->string('tmtweight')->nullable();
            $table->string('product_name');
            $table->string('slug');
            $table->boolean('wishlist')->default(false);
            $table->string('product_image');
            $table->string('brand')->nullable();
            $table->string('low_price')->nullable();
            $table->boolean('status')->default(true);
            $table->string('seo_title')->nullable();
            $table->string('seo_keyword')->nullable();
            $table->string('seo_description')->nullable();
            $table->integer('roofing_thickness_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
