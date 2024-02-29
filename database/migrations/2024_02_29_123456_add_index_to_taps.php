<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;


class AddIndexToTaps extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taps', function(Blueprint $table)
        {
            $table->index('tap_1');
            $table->index('tap_2');

        });

        Schema::table('tap_infos', function(Blueprint $table)
        {
            $table->index('tap');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taps', function (Blueprint $table)
        {
            $table->dropIndex(['tap_1']);
            $table->dropIndex(['tap_2']);

        });

        Schema::table('tap_infos', function (Blueprint $table)
        {
            $table->dropIndex(['tap']);

        });

    }

}


