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
        Schema::table('job_applications', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('job_applications', 'location')) {
                $table->string('location')->nullable(); // e.g., Remote, On-site
            }
            
            if (!Schema::hasColumn('job_applications', 'job_link')) {
                $table->string('job_link')->nullable(); // URL to the job listing
            }
            
            if (!Schema::hasColumn('job_applications', 'salary')) {
                $table->decimal('salary', 10, 2)->nullable(); // e.g., 60000.00
            }
            
            if (!Schema::hasColumn('job_applications', 'job_type')) {
                $table->string('job_type')->nullable(); // e.g., Full-time, Part-time, Contract
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('job_applications', 'location')) {
                $table->dropColumn('location');
            }
            
            if (Schema::hasColumn('job_applications', 'job_link')) {
                $table->dropColumn('job_link');
            }
            
            if (Schema::hasColumn('job_applications', 'salary')) {
                $table->dropColumn('salary');
            }
            
            if (Schema::hasColumn('job_applications', 'job_type')) {
                $table->dropColumn('job_type');
            }
        });
    }
};