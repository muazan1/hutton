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
        Schema::create('plot_jobs', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->unique();

            $table->integer('plot_id');

            $table->integer('service_id');

            $table
                ->decimal('percent_complete', $precision = 3, $scale = 2)
                ->default(0.0);

            $table
                ->decimal('amount', $precision = 10, $scale = 2)
                ->default(0.0);

            $table
                ->enum('status', [
                    'not-started',
                    'completed',
                    'partial-complete',
                ])
                ->default('not-started');

            $table->date('date_start')->nullable();

            $table->date('date_due')->nullable();

            $table->timestamp('last_activity')->nullable();

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
        Schema::dropIfExists('plot_jobs');
    }
}
