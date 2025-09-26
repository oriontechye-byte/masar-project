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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->integer('score_social');
            $table->integer('score_visual');
            $table->integer('score_intrapersonal');
            $table->integer('score_kinesthetic');
            $table->integer('score_logical');
            $table->integer('score_naturalist');
            $table->integer('score_linguistic');
            $table->integer('score_musical');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};