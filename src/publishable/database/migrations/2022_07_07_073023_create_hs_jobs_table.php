<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHsJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_jobs', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            $table->string('title');

            $table->text('detail');

            $table
                ->decimal('percent_complete', $precision = 3, $scale = 2)
                ->default(0.0);

            $table
                ->enum('status', [
                    'not-started',
                    'completed',
                    'partial-complete',
                ])
                ->default('not-started');

            $table->tinyInteger('private')->default(1);

            $table->date('date_start')->nullable();

            $table->date('date_due')->nullable();

            $table->tinyInteger('billable')->default(1);

            $table
                ->decimal('hourly_rate', $precision = 8, $scale = 2)
                ->default(0.0);

            $table->dateTime('date_started')->nullable();

            $table->dateTime('date_complete')->nullable();

            $table->integer('user_id');

            $table->integer('assigned_user_id');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_jobs');
    }
}
