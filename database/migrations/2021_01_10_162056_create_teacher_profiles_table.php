<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('desc')->nullable();
            $table->string('hour_price')->nullable();
            $table->string('group_price')->nullable();
            $table->text('availability_hours')->nullable();
            $table->string('portfolio')->nullable();

            $table->boolean('is_checked')->default(0);

            $table->unsignedInteger('module_id')->nullable();
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
        Schema::dropIfExists('teacher_profiles');
    }
}
