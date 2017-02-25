<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 录入数据修改信息表
 */
class CreateDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50)->nullable(); // 数据标题
            $table->string('location', 50); // 发生地区
            $table->string('code', 50); // 预警条件编码
            $table->string('status', 50); // 如果数据出问题但是操作人员没有生成处理事件，那么status为1，否则为0
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
        Schema::dropIfExists('datas');
    }
}
