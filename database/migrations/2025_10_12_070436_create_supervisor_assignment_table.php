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
        /**
            CREATE TABLE IF NOT EXISTS supervisor_assignment (
                submission_id BIGINT PRIMARY KEY REFERENCES thesis_submission(id) ON UPDATE CASCADE ON DELETE CASCADE,
                pembimbing1_id BIGINT NOT NULL REFERENCES lecturer(id) ON UPDATE CASCADE ON DELETE RESTRICT,
                pembimbing2_id BIGINT NULL REFERENCES lecturer(id) ON UPDATE CASCADE ON DELETE RESTRICT,
                ditetapkan_oleh VARCHAR(160) NOT NULL,
                tanggal TIMESTAMPTZ NOT NULL DEFAULT now()
            );
         */

        Schema::create('supervisor_assignment', function (Blueprint $table) {
            $table->foreignId('submission_id')->primary();
            $table->foreignId('pembimbing1_id');
            $table->foreignId('pembimbing2_id')->nullable();
            $table->string('ditetapkan_oleh', 160);
            $table->timestampTz('tanggal')->default(now());
            $table->timestampsTz();

            $table->foreign('submission_id')
                ->references('id')
                ->on('thesis_submission')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('pembimbing1_id')
                ->references('id')
                ->on('lecturer')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('pembimbing2_id')
                ->references('id')
                ->on('lecturer')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor_assignment');
    }
};
