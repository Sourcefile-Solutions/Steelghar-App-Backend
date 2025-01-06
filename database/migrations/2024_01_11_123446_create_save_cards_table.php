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
        Schema::create('save_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('saved_card_id');
            $table->string('card_holder');
            $table->string('city');
            $table->string('card_name');
            $table->string('card_no');
            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('save_cards');
    }
};
