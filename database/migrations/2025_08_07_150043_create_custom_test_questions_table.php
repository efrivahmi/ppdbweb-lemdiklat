<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('custom_test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_test_id')->constrained()->onDelete('cascade');
            $table->text('pertanyaan');
            $table->enum('tipe_soal', ['radio', 'text']);
            $table->json('options')->nullable(); // untuk radio button options
            $table->text('jawaban_benar')->nullable(); // untuk radio button
            $table->integer('urutan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('custom_test_questions');
    }
};