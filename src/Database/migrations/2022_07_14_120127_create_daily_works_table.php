<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_works', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->unique();

            $table->integer('week_id');

            $table->integer('plot_job_id');

            $table->integer('site_id');

            $table->integer('plot_id');

            $table->integer('service_id');

            $table->integer('day')->nullable();

            $table->text('fixes_performed')->nullable();

            $table->time('time_taken')->nullable();

            $table->decimal('amount', $precision = 8, $scale = 2)->default(0.0);

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
        Schema::dropIfExists('daily_works');
    }
}
