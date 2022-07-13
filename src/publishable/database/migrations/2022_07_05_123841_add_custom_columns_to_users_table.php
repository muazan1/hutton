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

            $table
                ->string('phone')
                ->after('email')
                ->nullable();

            $table
                ->string('address')
                ->after('password')
                ->nullable();

            $table
                ->string('two_factor_secret')
                ->after('address')
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
