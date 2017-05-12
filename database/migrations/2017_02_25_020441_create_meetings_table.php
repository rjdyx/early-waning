<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 会议表
 */
class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date'); // 会议日期
            $table->string('location', 50); // 会议地址
            $table->string('master', 50); // 主持人
            $table->string('meetinguser', 50)->nullable(); // 参加人员（作为不存在应急人员表或专家表时手动录入的人员）
            $table->string('recorder', 50)->nullable(); // 记录人员
            $table->string('title', 50); // 会议主题
            $table->text('content'); // 会议内容
            $table->string('meno', 255)->nullable(); // 备注
            $table->integer('status'); // 会议状态，1：待处理会议，2：正处理会议，3：历史会议
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
        Schema::dropIfExists('meetings');
    }
}
