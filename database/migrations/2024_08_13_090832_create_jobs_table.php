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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('comapny_id');
            $table->string('title')->nullable();
            $table->json('job_type')->nullable();
            $table->json('qualification')->nullable();
            $table->bigInteger('job_category')->nullable()->comment('id of job category');
            $table->bigInteger('job_role')->nullable()->comment('id of job role');
            $table->bigInteger('job_industry')->nullable()->comment('id of job industry');
            $table->bigInteger('vacancies')->default(1);
            $table->string('location')->nullable();
            $table->string('salary')->nullable();
            $table->string('salary_type')->nullable();
            $table->string('experience')->nullable();
            $table->longText('description')->nullable();
            $table->dateTimeTz('deadline')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1->active/published 2->inactive');
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
        Schema::dropIfExists('jobs');
    }
};
