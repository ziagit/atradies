<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('budget')->nullable();
            $table->string('need')->nullable();
            $table->string('service')->nullable();
            $table->string('status')->nullable();
            $table->string('time')->nullable();
            $table->string('icon')->nullable();
            $table->string('location_type')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger("service_id")->nullable();
            $table->unsignedInteger('address_id')->nullable();
            $table->unsignedInteger('contact_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
