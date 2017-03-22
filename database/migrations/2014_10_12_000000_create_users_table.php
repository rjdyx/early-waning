<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->unique();
            $table->string('email', 50)->unique();
            $table->string('password');
            //是否冻结用户的标志，
            //0：否，
            //1：是，
            //默认0
            $table->integer('active')->default(0); 
            // 用户角色
            // 0: 管理员,
            // 1: 专家,
            // 2: 应急人员
            // 默认0
            $table->integer('role')->default(0); 
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
