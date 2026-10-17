<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique();
            $table->string('name');
            $table->string('category'); // Laptop, Kendaraan, HP, dll
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete(); // Siapa yang pegang
            $table->date('purchase_date')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance', 'broken'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
