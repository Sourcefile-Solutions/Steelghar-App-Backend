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
        Schema::create('registered_fabricators', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('gst')->nullable();
            $table->string('pan')->nullable();
            $table->string('aadhaar')->nullable();
            $table->string('business_agreement')->nullable();
            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registered_fabricators');
    }
};
