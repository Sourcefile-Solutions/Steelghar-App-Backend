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
            $table->id();
            $table->string('order_id')->nullable();
            $table->integer('customer_id');
            $table->integer('address_id_for_billing');
            $table->integer('address_id_for_shipping');
            $table->boolean('order_status')->default(false);  //true->placed
            $table->string('current_status')->default('ORDER PLACED');

            $table->boolean('is_full_payment')->default(1); // 1 full payment 0 partial payment
            $table->string('sub_total'); // sum of product prices * qty
            $table->string('shipping_charge');
            $table->string('handling_charge');
            $table->string('gst_charge');
            $table->string('payable_amount'); // grand total amount need to pay
            $table->string('advance_amount');
            $table->string('pay_later_amount');
            $table->string('paid_amount')->nullable(); // ++each paid
            $table->string('balance_amount')->nullable(); //payable_amount - paid_amount

            $table->timestamp('order_date')->nullable();

            $table->string('total_km');
            $table->string('total_weight');

            $table->string('razorpay_order_id')->nullable();

            $table->boolean('is_approved')->default(0);
            $table->boolean('is_canceled')->default(0);
            $table->boolean('is_rejected')->default(0);
            $table->string('cancel_reson', 5000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
