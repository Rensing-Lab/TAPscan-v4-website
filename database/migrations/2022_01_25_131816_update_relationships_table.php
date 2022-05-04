<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('species_tax_ids', function (Blueprint $table) {
        $table->foreignId('family_id')->nullable()->constrained('families');
        $table->foreignId('order_id')->nullable()->constrained('orders');
        $table->foreignId('supergroup_id')->nullable()->constrained('supergroups');
        $table->foreignId('clade_id')->nullable()->constrained('clades');
        $table->foreignId('kingdom_id')->nullable()->constrained('kingdoms');
      });

      // Schema::table('taps', function (Blueprint $table) {
      //   $table->foreignId('species_id')->constrained('species_tax_ids');
      // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
