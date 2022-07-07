<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            $table->string('customer_name');

            $table->string('slug')->index();

            $table->string('email')->unique();

            $table->string('street_1');

            $table->string('street_2')->nullable();

            $table->string('city');

            $table->string('postcode');

            $table->string('telephone_number');

            $table->string('county')->nullable();

            $table->foreignId('customer_type')->default(true);

            $table->foreignId('contract_type')->default(1);

            $table->date('contract_expiry_date')->nullable();

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
        Schema::dropIfExists('customers');
    }
}
