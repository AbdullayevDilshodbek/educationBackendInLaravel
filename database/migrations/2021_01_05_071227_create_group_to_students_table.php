<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_to_students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('group_id')->unsigned();
            $table->integer('credit');
            $table->float('discount')->default(0.0);
            $table->boolean('status')->default(true);
            $table->date('change_group_date')->nullable();
            $table->integer('pay_part')->default(100);
            $table->unique(['student_id','group_id']);
//            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
//            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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
//        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('group_to_students');
//        Schema::enableForeignKeyConstraints();
    }
}
