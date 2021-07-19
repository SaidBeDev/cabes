<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('module_id')->unsigned();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('locale')->index();

            $table->unique(['module_id', 'locale']);
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_translations');
    }
}
