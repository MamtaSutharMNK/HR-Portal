<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('job_details', function (Blueprint $table) {
            $table->id();
            $table->string('fte_request_id')->nullable();
            $table->string('job_title');
            $table->integer('experience')->nullable();
            $table->text('education');
            $table->text('language_required')->nullable();
            $table->text('certifications')->nullable();
            $table->text('job_description')->nullable();
            $table->text('key_skills')->nullable();
            $table->timestamps();

            $table->foreign('fte_request_id')->references('request_uuid')->on('request_forms')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_details');
    }
};
