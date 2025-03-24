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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade'); // Student belongs to a School
            $table->foreignId('school_class_id')->constrained()->onDelete('cascade'); // Student belongs to a Class
            $table->string('first_name');
            $table->string('surname');
            $table->string('last_name');
            $table->string('state');
            $table->string('lga');
            $table->string('address');
            $table->string('phone_number');
            $table->string('student_photo')->nullable();
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('mentors_name');
            $table->string('mentors_address');
            $table->string('mentors_phone');
            $table->string("fathers_name");
            $table->string("fathers_address");
            $table->string("fathers_phone_number");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
