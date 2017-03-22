<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 应急人员表
 */
class CreateEmergencyCrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_crews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50); // 姓名
            $table->integer('age')->nullable(); // 年龄
            $table->integer('sex')->default(0); // 性别，1：男，0：女，默认1
            $table->string('duty', 20); // 职责
            $table->string('title', 20); // 职务
            $table->string('phone', 15)->nullable(); // 固定电话
            $table->string('cellphone', 15)->nullable(); // 手机
            $table->string('email', 50)->nullable(); // 邮箱
            $table->string('meno', 255)->nullable(); // 备注
            $table->integer('org_id')->unsigned(); // 所属机构
            $table->integer('user_id')->unsigned()->nullable(); // 对应用户
            $table->timestamps();

            $table->foreign('org_id')->references('id')->on('orgs')
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
        Schema::dropIfExists('emergency_crews');
    }
}
