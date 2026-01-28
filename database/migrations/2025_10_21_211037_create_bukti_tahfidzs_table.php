<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukti_tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_murid_id')->constrained('pendaftaran_murids')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type'); // pdf, jpg, jpeg, png
            $table->integer('file_size'); // dalam bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_tahfidzs');
    }
};