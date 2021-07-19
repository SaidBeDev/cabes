<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyYearTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_year_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('study_year_id')->unsigned();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('locale')->index();

            $table->unique(['study_year_id', 'locale']);
            $table->foreign('study_year_id')->references('id')->on('study_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_year_translations');
    }
}
