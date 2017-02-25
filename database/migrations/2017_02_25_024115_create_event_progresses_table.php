<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 事件进度表
 */
class CreateEventProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_progresses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content'); // 进度详情
            $table->integer('event_id')->unsigned(); // 事件
            $table->integer('user_id')->unsigned(); // 进度发布者
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_progresses');
    }
}
