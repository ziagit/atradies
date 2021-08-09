<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('jobstatus_id')->default(1);
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
        Schema::dropIfExists('user_jobs');
    }
}
