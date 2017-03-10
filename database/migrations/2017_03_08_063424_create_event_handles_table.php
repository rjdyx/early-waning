<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventHandlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_handles', function (Blueprint $table) {
            $table->integer('event_id')->unsigned();
            $table->integer('plan_id')->unsigned();
            $table->integer('expert_id')->unsigned();
            $table->integer('information_id')->unsigned();

            $table->foreign('event_id')->references('id')->on('events')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('expert_id')->references('id')->on('experts')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('information_id')->references('id')->on('informations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['event_id', 'plan_id', 'expert_id', 'information_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_handles');
    }
}
