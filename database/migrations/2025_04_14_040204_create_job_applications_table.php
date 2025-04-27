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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('job_title');
            $table->string('company_name');
            $table->string('status')->default('Applied'); // e.g., Applied, Interviewing, Offer, Rejected
            $table->date('application_date')->nullable();
            $table->text('notes')->nullable();
            $table->date('reminder_date')->nullable();
            $table->timestamps();
            $table->string('location')->nullable(); // e.g., Remote, On-site
            $table->string('job_link')->nullable(); // URL to the job listing
            $table->decimal('salary', 10, 2)->nullable(); // e.g., 60000.00
            $table->string('job_type')->nullable(); // e.g., Full-time, Part-time, Contract
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
