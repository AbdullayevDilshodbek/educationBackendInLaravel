<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');
            $table->bigInteger('teacher_id')->unsigned();
            $table->integer('payment');
            $table->float('teacher_part');
            $table->boolean('status')->default(true);
//            $table->foreign('teacher_id')->references('id')->on('teachers')
//                ->onDelete('cascade');
            $table->unique(['teacher_id','group_name']);
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
//        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('groups');
//        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
