<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('custom_test_id')->constrained()->onDelete('cascade');
            $table->foreignId('custom_test_question_id')->constrained()->onDelete('cascade');
            $table->text('jawaban');
            $table->boolean('is_correct')->nullable(); // Nullable untuk essay yang belum direview
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'custom_test_question_id'], 'unique_user_question_answer');
            $table->index(['user_id', 'custom_test_id'], 'idx_user_test');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_test_answers');
    }
};