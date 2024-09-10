<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Change 'email' column to allow NULL values and remove unique constraint
            $table->string('email')->nullable()->change();

            // Rename 'is_profile' column to 'is_profile_completed'
            $table->renameColumn('is_porfile_completed', 'is_profile_completed');
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
            // Revert 'email' column to NOT NULL and re-add unique constraint
            $table->string('email')->nullable(false)->unique()->change();

            // Rename 'is_profile_completed' column back to 'is_profile'
            $table->renameColumn('is_profile_completed', 'is_porfile_completed');
        });
    }
};
