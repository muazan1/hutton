<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoinersPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joiner_pricings', function (Blueprint $table) {
            $table->id();

            $table->integer('builder_id');

            $table->integer('joiner_id');

            $table->decimal('price', $precision = 8, $scale = 2)->default(0.0);

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
        Schema::dropIfExists('joiner_pricings');
    }
}
