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
        Schema::table('request_forms', function (Blueprint $table) {
                $table->dropColumn([
                'hr_email_l2',
                'hr_email_l3',
                'employment_category',
                'department_function',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_forms', function (Blueprint $table) {
            $table->string('hr_email_l2')->nullable();
            $table->string('hr_email_l3')->nullable();
            $table->longText('employment_category');
            $table->string('department_function');

        });
    }
};
