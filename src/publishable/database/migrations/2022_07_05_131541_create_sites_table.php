<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();

            // $table->string('uuid')->unique();

            $table->foreignId('customer_id');

            $table->string('site_name');

            $table->string('slug')->index();

            $table->string('street_1');

            $table->string('street_2')->nullable();

            $table->string('city');

            $table->string('postcode');

            $table->string('county')->nullable();

            $table->string('telephone');

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
        Schema::dropIfExists('sites');
    }
}
