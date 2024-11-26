<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();


            $table->string('title')->unique();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('advertiser_phone')->nullable();
            $table->string('email')->nullable();
            $table->json('images')->nullable();
            $table->string('video_link')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->bigInteger('views')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->unsignedBigInteger('advertisement_location_id')->nullable();
            $table->foreign('advertisement_location_id')->references('id')->on('advertisement_locations')->onUpdate('cascade')->onDelete('cascade');

            // point this
            $table->unsignedBigInteger('adv_category_id')->nullable();
            $table->foreign('adv_category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('owner',128)->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('seo_desc')->nullable();
            $table->string('keywords')->nullable();




            $table->index('title');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
