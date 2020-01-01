<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes_table', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("module_id");
            $table->integer("etudiant_id");
            $table->enum("type", ["CC", "CF", "CI"]);
            $table->float("valeur");
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
        Schema::dropIfExists('notes_table');
    }
}
