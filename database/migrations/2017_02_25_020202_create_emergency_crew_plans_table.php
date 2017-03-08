<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 应急人员-预案关联表
 */
class CreateEmergencyCrewPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_crew_plans', function (Blueprint $table) {
            $table->integer('emergency_crew_id')->unsigned();
            $table->integer('plan_id')->unsigned();
            $table->integer('title'); // 1：组长，2：副组长，3：成员

            $table->foreign('emergency_crew_id')->references('id')->on('emergency_crews')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['emergency_crew_id', 'plan_id', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_crew_plans');
    }
}
