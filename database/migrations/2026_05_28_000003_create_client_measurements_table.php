<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('measured_at');
            $table->string('appointment_type')->default('Valoracion inicial');
            $table->decimal('weight', 6, 2)->nullable();
            $table->decimal('body_fat', 5, 2)->nullable();
            $table->decimal('lean_mass', 6, 2)->nullable();
            $table->decimal('fat_mass', 6, 2)->nullable();
            $table->decimal('waist', 6, 2)->nullable();
            $table->decimal('chest', 6, 2)->nullable();
            $table->decimal('hip', 6, 2)->nullable();
            $table->decimal('arm', 6, 2)->nullable();
            $table->decimal('thigh', 6, 2)->nullable();
            $table->decimal('calf', 6, 2)->nullable();
            $table->decimal('target_body_fat', 5, 2)->nullable();
            $table->decimal('target_weight', 6, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_measurements');
    }
};
