<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 专家表
 */
class CreateExpertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50); // 姓名
            $table->integer('sex')->default(0); // 性别，1：男，0：女，默认1
            $table->string('degree', 20)->nullable(); // 学历
            $table->string('duty', 20); // 职责
            $table->string('title', 20); // 职务
            $table->string('address', 50)->nullable(); // 住址
            $table->string('zipcode', 20)->nullable(); // 邮编
            $table->string('company', 50)->nullable(); // 单位
            $table->string('officephone', 15)->nullable(); // 办公电话
            $table->string('homephone', 15)->nullable(); // 宅电
            $table->string('cellphone', 15)->nullable(); // 手机
            $table->string('email', 50)->nullable(); // 邮箱
            $table->string('meno', 255)->nullable(); // 备注
            $table->integer('org_id')->unsigned(); // 所属机构
            $table->integer('expert_area_id')->unsigned(); // 专家领域
            $table->timestamps();

            $table->foreign('org_id')->references('id')->on('orgs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('expert_area_id')->references('id')->on('normal_types')
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
        Schema::dropIfExists('experts');
    }
}
