<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('courier_id')->unsigned()->index()->nullable();
            $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('set null');
            $table->string('shipping_code');
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('sender_region');
            $table->text('sender_address');
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->string('pickup_photo')->nullable();
            $table->integer('status');
            $table->bigInteger('total_pay');
            $table->bigInteger('total_weight');
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
        Schema::dropIfExists('shipments');
    }
}
