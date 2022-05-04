<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupergroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supergroups', function (Blueprint $table) {
            $table->id();
            $table->string('supergroup')->unique();
            $table->timestamps();
            $table->foreignId('clade_id')->nullable()->constrained('clades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supergroups');
    }
}
