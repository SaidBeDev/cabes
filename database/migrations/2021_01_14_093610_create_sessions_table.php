<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('capacity');
            $table->string('nbr_hours');
            $table->string('credit_cost');
            $table->string('hour_from');
            $table->string('hour_to');
            $table->string('link')->default(null);
            $table->string('g_link')->default(null);
            $table->string('image')->default(null);
            $table->date('date');

            $table->boolean('is_canceled')->default(false);
            $table->boolean('is_completed')->default(false);

            $table->unsignedInteger('period_id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('module_id')->default(1);
            $table->unsignedInteger('study_year_id')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
