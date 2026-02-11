<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->text('description')->nullable()->after('content');
            $table->unsignedInteger('views_count')->default(0)->after('is_active');
            $table->unsignedInteger('likes_count')->default(0)->after('views_count');
            $table->unsignedInteger('dislikes_count')->default(0)->after('likes_count');
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['description', 'views_count', 'likes_count', 'dislikes_count']);
        });
    }
};
