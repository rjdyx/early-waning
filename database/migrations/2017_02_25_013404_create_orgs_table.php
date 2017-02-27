<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 检验机构表
 */
class CreateOrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50); // 机构名称
            $table->string('address', 50)->nullable(); // 机构地址
            $table->string('zipcode', 20)->nullable(); // 邮编
            $table->string('phone', 15)->nullable(); // 固定电话
            $table->string('cellphone', 15)->nullable(); // 移动电话
            $table->string('fax', 15)->nullable(); // 传真
            $table->string('meno', 255)->nullable(); // 备注
            $table->integer('pid')->unsigned()->default(0); // 父机构，0：表示最顶层机构
            $table->integer('org_level_id')->unsigned(); // 机构类别
            $table->timestamps();

            $table->foreign('pid')->references('id')->on('orgs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('org_level_id')->references('id')->on('normal_types')
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
        Schema::dropIfExists('orgs');
    }
}
