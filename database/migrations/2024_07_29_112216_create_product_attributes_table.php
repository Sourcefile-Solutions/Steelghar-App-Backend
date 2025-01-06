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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('thickness')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('roof_thickness')->nullable();
            $table->string('price')->nullable();
            $table->string('price_kg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
