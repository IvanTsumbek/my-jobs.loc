<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->index('external_id');
            $table->index('is_remote');
            $table->index('category');
        });
    
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->index('is_active');
        });
    }
    
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropIndex(['external_id']);
            $table->dropIndex(['is_remote']);
            $table->dropIndex(['category']);
        });
    
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });
    }
};
