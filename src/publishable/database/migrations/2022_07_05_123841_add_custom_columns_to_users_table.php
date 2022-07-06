<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->uuid('uuid')
                ->unique()
                ->after('id');

            $table
                ->foreignId('role_id')
                ->default(2)
                ->after('uuid');

            $table->string('first_name')->after('role_id');

            $table->string('last_name')->after('first_name');

            $table
                ->string('two_factor_secret')
                ->after('password')
                ->nullable();

            $table
                ->string('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
