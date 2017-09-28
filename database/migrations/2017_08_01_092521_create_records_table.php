<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tbl_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('arduino_id');
            $table->integer('ppm');
            $table->double('humidity');
            $table->double('temp_in_c');
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
        //
        Schema::dropIfExists('tbl_records');
    }
}
