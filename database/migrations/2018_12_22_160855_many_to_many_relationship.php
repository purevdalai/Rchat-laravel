<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ManyToManyRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('many_relationship', function (Blueprint $table) {
            Schema::create('user_task' , function($table) {
                $table->integer('user_id')->unsigned();
                $table->integer('task_id')->unsigned();
            });
            
            Schema::create('user_question' , function($table) {
                $table->integer('user_id')->unsigned();
                $table->integer('question_id')->unsigned();
            });
            
            Schema::create('user_meeting' , function($table) {
                $table->integer('user_id')->unsigned();
                $table->integer('meeting_id')->unsigned();
            });
    
            Schema::create('room_user' , function($table) {
                $table->integer('user_id')->unsigned();
                $table->integer('room_id')->unsigned();
                $table->boolean('admin')->default(false);
                $table->bigInteger('count_record')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_task');
        Schema::dropIfExists('user_question');
        Schema::dropIfExists('user_meeting');
        Schema::dropIfExists('room_user');
    }
}
