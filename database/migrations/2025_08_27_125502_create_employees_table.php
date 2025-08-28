<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('full_name');
            $table->string('guardian_name')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male','female','other'])->nullable();
            $table->string('cnic', 50)->nullable()->unique();
            $table->string('phone', 30)->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('photo_path')->nullable();
            $table->date('joining_date')->nullable();
            $table->enum('employment_type', ['full-time','part-time','contract','intern'])->default('full-time');
            $table->decimal('salary_amount', 12, 2)->nullable();
            $table->string('cv_path')->nullable();
            $table->string('shift_name')->nullable();
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->string('education_level')->nullable();
            $table->string('university_college')->nullable();
            $table->string('internship_department')->nullable();
            $table->date('internship_start')->nullable();
            $table->date('internship_end')->nullable();
            $table->string('internship_duration')->nullable();
            $table->boolean('stipend')->default(false);
            $table->decimal('stipend_amount', 12, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
