<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerCoordinatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_coordinates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->string('latitude',100)->nullable();
            $table->string('longitude',100)->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('seller_coordinates');
    }
}
