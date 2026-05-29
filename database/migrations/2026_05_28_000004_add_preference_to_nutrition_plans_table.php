<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nutrition_plans', function (Blueprint $table) {
            $table->string('preference')->nullable()->after('status')->index();
        });
    }

    public function down(): void
    {
        Schema::table('nutrition_plans', function (Blueprint $table) {
            $table->dropColumn('preference');
        });
    }
};
