<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_works', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');

            $table->date('week_start');

            $table->date('week_end');

            $table->enum('status', [
                'completed',
                'in-progress',
                'not-completed',
            ]);

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
        Schema::dropIfExists('weekly_works');
    }
}
