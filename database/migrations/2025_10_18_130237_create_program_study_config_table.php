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
        Schema::create('program_study_config', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id');
            $table->smallInteger('submission_min_sks')->default(0)->check('submission_min_sks >= 0');
            $table->boolean('submission_require_financial_clear')->default(true);
            $table->timestampsTz();

            $table->foreign('prodi_id')
                ->references('id')
                ->on('program_study')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_study_config');
    }
};
