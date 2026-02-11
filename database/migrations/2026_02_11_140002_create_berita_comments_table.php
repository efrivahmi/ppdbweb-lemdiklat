<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained('beritas')->onDelete('cascade');
            $table->string('name');
            $table->text('message');
            $table->string('ip_address', 45);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->index(['berita_id', 'is_approved']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_comments');
    }
};
