<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workout_plan_exercises', function (Blueprint $table) {
            $table->string('block_group', 20)->nullable()->after('block_type');
        });
    }

    public function down(): void
    {
        Schema::table('workout_plan_exercises', function (Blueprint $table) {
            $table->dropColumn('block_group');
        });
    }
};
