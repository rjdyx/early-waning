<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 机构类别表
 */
class CreateNormalTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('normal_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10); //机构类别名
            /**
             * 1：机构类型
             * 2：专家领域
             * 3：预案类型
             * 4：专题类型
             * 5：事件等级
             * 6：事件类型
             */
            $table->integer('type')->unsigned();
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
        Schema::dropIfExists('normal_types');
    }
}
