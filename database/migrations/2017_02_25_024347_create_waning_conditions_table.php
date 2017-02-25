<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 预警条件表
 */
class CreateWaningConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waning_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50); // 预警条件编码
            $table->string('description', 50); // 条件描述
            $table->integer('type'); // 条件出发的事件类型，1：预警事件，2：突发事件
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
        Schema::dropIfExists('waning_conditions');
    }
}
