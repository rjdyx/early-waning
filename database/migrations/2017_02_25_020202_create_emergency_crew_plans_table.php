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
            $table->string('duty', 20); // 职责
            $table->string('title', 20); // 职务

            $table->foreign('emergency_crew_id')->references('id')->on('emergency_crews')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['emergency_crew_id', 'plan_id']);
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
