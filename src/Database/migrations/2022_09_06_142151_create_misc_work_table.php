<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiscWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misc_works', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->unique();

            $table->integer('week_id');

            $table->integer('site_id');

            $table->string('title');

            $table->text('work_carried')->nullable();

            $table->time('time_taken');

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
        Schema::dropIfExists('misc_works');
    }
}
