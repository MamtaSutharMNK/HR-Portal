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
            $table->dropForeign(['employee_level_id']);

            $table->dropColumn('employee_level_id');

        });

        Schema::dropIfExists('employee_levels');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_level_id')->nullable();
            $table->foreign('employee_level_id')->references('id')->on('employee_levels')->onDelete('set null');
        });

        Schema::create('employee_levels', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->timestamps();
        });

    }
};
