<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectorTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sector_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sector_id')->unsigned();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('locale')->index();

            $table->unique(['sector_id', 'locale']);
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sector_translations');
    }
}
