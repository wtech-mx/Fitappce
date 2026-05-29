<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereIn('body_visual_type', ['scan', 'realistic', 'silhouette', 'athletic'])
            ->update(['body_visual_type' => 'avatar']);
    }

    public function down(): void
    {
        DB::table('users')
            ->where('body_visual_type', 'avatar')
            ->update(['body_visual_type' => 'scan']);
    }
};
