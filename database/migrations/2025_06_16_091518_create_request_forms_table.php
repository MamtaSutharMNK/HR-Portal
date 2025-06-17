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
Schema::create('request_forms', function (Blueprint $table) {
            $table->id();
            $table->string('request_uuid')->unique();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('function_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('requested_by');
            $table->date('date_of_request');
            $table->longText('location_type');
            $table->integer('no_of_positions');
            $table->longtext('type_of_employment');
            $table->longtext('employment_category');
            $table->longtext('requisition_type');
            $table->longtext('recruitment_source')->nullable();
            $table->longtext('work_permit')->nullable();
            $table->longtext('relocation_support')->nullable();
            $table->string('work_location', 255)->nullable();
            $table->date('target_start_date')->nullable();
            $table->string('ctc_type');
            $table->decimal('ctc_start_range',10,2); 
            $table->decimal('ctc_end_range',10,2);   
            $table->integer('experience')->nullable();
            $table->text('justification_details')->nullable();
            $table->string('replacing_employee', 255)->nullable();
            $table->text('consequences_of_not_hiring')->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('set null');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('function_id')->references('id')->on('job_roles')->onDelete('set null');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_forms');
    }
};
