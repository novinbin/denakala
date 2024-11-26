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

            $table->string('order_number',64)->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');



            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->string('gateway',128)->nullable();



            $table->unsignedBigInteger('common_discount_id')->nullable();
            $table->foreign('common_discount_id')->references('id')->on('common_discount')->onDelete('cascade');


            $table->decimal('order_common_discount_amount',20,3)->nullable();


            $table->tinyInteger('payment_type')->default(0);

            $table->tinyInteger('payment_status')->default(0);

            $table->decimal('order_final_amount',20,3)->nullable();

            $table->decimal('order_discount_amount',20,3)->nullable();

            $table->decimal('order_final_amount_payable',20,3)->nullable();

            $table->tinyInteger('order_status')->default(0);

            $table->softDeletes();
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
