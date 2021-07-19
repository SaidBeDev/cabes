<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('desc');
            $table->text('objectives');
            $table->string('locale')->index();

            $table->unique(['session_id', 'locale']);
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_translations');
    }
}
