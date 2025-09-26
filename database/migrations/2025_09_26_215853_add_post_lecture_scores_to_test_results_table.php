<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            // We will make the old columns nullable, as a record might only have post-test scores initially
            $table->integer('score_social')->nullable()->change();
            $table->integer('score_visual')->nullable()->change();
            $table->integer('score_intrapersonal')->nullable()->change();
            $table->integer('score_kinesthetic')->nullable()->change();
            $table->integer('score_logical')->nullable()->change();
            $table->integer('score_naturalist')->nullable()->change();
            $table->integer('score_linguistic')->nullable()->change();
            $table->integer('score_musical')->nullable()->change();

            // Add new columns for the post-lecture scores
            $table->integer('post_score_social')->nullable();
            $table->integer('post_score_visual')->nullable();
            $table->integer('post_score_intrapersonal')->nullable();
            $table->integer('post_score_kinesthetic')->nullable();
            $table->integer('post_score_logical')->nullable();
            $table->integer('post_score_naturalist')->nullable();
            $table->integer('post_score_linguistic')->nullable();
            $table->integer('post_score_musical')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            // Logic to reverse the changes
            $table->dropColumn([
                'post_score_social', 'post_score_visual', 'post_score_intrapersonal',
                'post_score_kinesthetic', 'post_score_logical', 'post_score_naturalist',
                'post_score_linguistic', 'post_score_musical'
            ]);
            // Revert old columns back to not nullable if needed
        });
    }
};