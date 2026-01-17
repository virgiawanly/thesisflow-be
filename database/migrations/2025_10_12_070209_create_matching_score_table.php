<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
            CREATE TABLE IF NOT EXISTS matching_score (
                submission_id BIGINT NOT NULL REFERENCES thesis_submission(id) ON UPDATE CASCADE ON DELETE CASCADE,
                lecturer_id BIGINT NOT NULL REFERENCES lecturer(id) ON UPDATE CASCADE ON DELETE CASCADE,
                skor NUMERIC(5,2) NOT NULL,
                detail_json JSONB NULL,
                PRIMARY KEY (submission_id, lecturer_id)
            );

            CREATE INDEX IF NOT EXISTS idx_matching_skor_desc ON matching_score(skor DESC);
         */

        Schema::create('matching_score', function (Blueprint $table) {
            $table->foreignId('submission_id');
            $table->foreignId('lecturer_id');
            $table->decimal('skor', 5, 2);
            $table->jsonb('detail_json')->nullable();
            $table->timestampsTz();

            $table->foreign('submission_id')
                ->references('id')
                ->on('thesis_submission')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturer')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['submission_id', 'lecturer_id']);
        });

        DB::statement('CREATE INDEX idx_matching_skor_desc ON matching_score(skor DESC)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matching_score');
    }
};
