<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('division_id')->nullable()->constrained()->nullOnDelete();

            // Identitas
            $table->string('employee_number', 30)->unique()->nullable();
            $table->string('full_name');
            $table->string('nickname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('nik', 20)->nullable()->comment('Nomor KTP');
            $table->string('npwp', 30)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();

            // Kepegawaian
            $table->string('position')->nullable();
            $table->enum('employment_status', ['permanent', 'contract', 'intern', 'probation'])->default('contract');
            $table->date('join_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('salary', 15, 2)->nullable();

            // Alamat
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();

            // Kontak darurat
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['division_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
