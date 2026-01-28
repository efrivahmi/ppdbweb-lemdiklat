<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tes_jalur_custom_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tes_jalur_id')->constrained()->onDelete('cascade');
            $table->foreignId('custom_test_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tes_jalur_custom_tests');
    }
};