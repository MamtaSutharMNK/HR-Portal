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
            $table->tinyInteger('approval_level')->unsigned()->nullable()->after('requested_by');
            $table->string('hr_email')->after('manager_email');
            $table->string('level2_email')->nullable()->after('hr_email');
            $table->string('level3_email')->nullable()->after('level2_email');
            $table->string('reason')->nullable()->after('status');
             $table->string('position_filled')->nullable()->after('no_of_positions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_forms', function (Blueprint $table) {
            $table->dropColumn([
                'approval_level',
                'hr_email',
                'level2_email',
                'level3_email',
                'reason',
                'position_filled'
            ]);
        });
    }
};
