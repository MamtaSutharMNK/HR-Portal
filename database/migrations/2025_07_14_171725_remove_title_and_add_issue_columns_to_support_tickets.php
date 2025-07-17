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
        Schema::table('support_tickets', function (Blueprint $table) 
        {
            $table->dropColumn('title');

            $table->foreignId('issue_category_id')->nullable()->constrained('issue_categories')->after('department_id');
            
            $table->foreignId('issue_type_id')->nullable()->constrained('issue_types')->after('issue_category_id');
            
            $table->string('temp_issue_cat')->nullable()->comment('Stores custom category when non-admin selects "other"')
                ->after('issue_type_id');
            
            $table->string('temp_issue_type')->nullable()->comment('Stores custom type when non-admin selects "other"')
                ->after('temp_issue_cat');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        {
            Schema::table('support_tickets', function (Blueprint $table) {
                $table->string('title')->nullable();

                $table->dropForeign(['issue_cat_id']); 
                $table->dropForeign(['issue_type_id']); 
                $table->dropColumn([
                    'issue_cat_id',
                    'issue_type_id',
                    'temp_issue_cat',
                    'temp_issue_type'
                ]);
            });
        }
};
