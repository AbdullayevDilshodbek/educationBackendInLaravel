<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')/*->unsigned()*/;
            $table->bigInteger('subject_id')/*->unsigned()*/;
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->unique(['user_id','subject_id']);
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
        Schema::dropIfExists('teachers');
    }
}
