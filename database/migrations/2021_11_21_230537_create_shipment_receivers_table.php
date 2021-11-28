<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_receivers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shipment_id')->unsigned()->index();
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_region');
            $table->string('receiver_address');
            $table->integer('weight');
            $table->string('dimension');
            $table->integer('ongkir');
            $table->string('photo')->nullable();
            $table->string('received_photo')->nullable();
            $table->text('notes')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('shipment_receivers');
    }
}
