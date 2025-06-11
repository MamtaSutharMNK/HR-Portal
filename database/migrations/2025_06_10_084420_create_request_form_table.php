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
        Schema::create('request_form', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_request');
            $table->text('location_type');
            $table->integer('no_of_positions');
            $table->text('type_of_employment');
            $table->text('employment_category');
            $table->text('requisition_type');
            $table->text('recruitment_source');
            $table->text('work_permit');
            $table->text('relocation_support');
            $table->string('work_location', 255);
            $table->date('target_start_date');
            $table->integer('experience')->unsigned();
            $table->text('justification_details');
            $table->string('replacing_employee', 255)->nullable();
            $table->text('consequences_of_not_hiring')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_form');
    }
};
