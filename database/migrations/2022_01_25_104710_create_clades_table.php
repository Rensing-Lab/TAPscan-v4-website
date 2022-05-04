<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCladesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clades', function (Blueprint $table) {
            $table->id();
            $table->string('clade')->unique();
            $table->timestamps();
            $table->foreignId('kingdom_id')->nullable()->constrained('kingdoms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clades');
    }
}
