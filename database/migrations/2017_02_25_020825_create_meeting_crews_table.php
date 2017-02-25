<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 会议-人员关联表
 */
class CreateMeetingCrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_crews', function (Blueprint $table) {
            $table->integer('meeting_id')->unsigned();
            $table->integer('emergency_crew_id')->unsigned();
            $table->integer('expert_id')->unsigned();

            $table->foreign('meeting_id')->references('id')->on('meetings')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('emergency_crew_id')->references('id')->on('emergency_crews')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('expert_id')->references('id')->on('experts')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['meeting_id', 'emergency_crew_id', 'expert_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_crews');
    }
}
