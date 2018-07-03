<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->string('details')->nullable();
            $table->integer('store_id')->nullable()->unsigned();
            $table->integer('brand_id')->nullable()->unsigned();
            $table->integer('image_id')->nullable()->unsigned();;
            $table->timestamps();
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
