<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 事件表
 */
class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50); // 事件名称
            $table->string('location', 50); // 发生地区
            $table->text('detail'); // 事件详情
            $table->integer('status'); // 事件状态，1：待处理预警事件，2：正处理预警事件，3：历史预警事件，4：待处理突发事件，5：正处理突发事件，6：历史突发事件，7：科学评价后的突发事件
            $table->integer('event_level_id')->unsigned(); // 事件等级
            $table->integer('event_sort_id')->unsigned(); // 事件类别
            $table->timestamps();

            $table->foreign('event_level_id')->references('id')->on('event_levels')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('event_sort_id')->references('id')->on('event_sorts')
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
        Schema::dropIfExists('events');
    }
}
