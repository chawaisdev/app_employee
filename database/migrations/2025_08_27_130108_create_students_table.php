<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
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
            $table->date('enrollment_date')->nullable();
            $table->string('course_program')->nullable();
            $table->string('batch_session')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('fee_amount', 12, 2)->nullable();
            $table->enum('payment_status', ['pending','paid','partial'])->default('pending');
            $table->string('education_level')->nullable();
            $table->string('university_college')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
