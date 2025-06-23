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
            $table->unsignedBigInteger('user_id');
            $table->string('request_uuid')->unique();
            $table->date('date_of_request');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('country');
            $table->string('requested_by');
            $table->string('manager_name');
            $table->string('manager_email');
            $table->integer('no_of_positions');
            $table->longtext('type_of_employment');
            $table->longtext('employment_category');
            $table->string('work_location', 255)->nullable();
            $table->date('target_by_when')->nullable();
            $table->string('department_function');
            $table->string('employee_level');
            $table->string('currency');                                                                                                                                 
            $table->string('ctc_type');
            $table->decimal('ctc_start_range',10,2); 
            $table->decimal('ctc_end_range',10,2);   
            $table->integer('experience')->nullable();
            $table->longtext('requisition_type');
            $table->text('justification_details')->nullable();
            $table->string('replacing_employee', 255)->nullable();
            $table->text('consequences_of_not_hiring')->nullable();
            $table->integer('status')->default(1);
            $table->integer('mail_status')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('requesting_branches')->onDelete('set null');
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
