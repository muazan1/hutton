<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriortyColumnInPlotJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plot_jobs', function (Blueprint $table) {
            $table
                ->integer('priority')
                ->nullable()
                ->after('status');

            $table
                ->integer('is_locked')
                ->default(1)
                ->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plot_jobs', function (Blueprint $table) {
            //
        });
    }
}
