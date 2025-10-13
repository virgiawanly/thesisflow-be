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
            CREATE TABLE IF NOT EXISTS review_log (
                id BIGSERIAL PRIMARY KEY,
                submission_id BIGINT NOT NULL REFERENCES thesis_submission(id) ON UPDATE CASCADE ON DELETE CASCADE,
                actor VARCHAR(160) NOT NULL,
                role VARCHAR(32) NOT NULL,
                action VARCHAR(64) NOT NULL,
                note TEXT NULL,
                created_at TIMESTAMPTZ NOT NULL DEFAULT now()
            );
         */

        Schema::create('review_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id');
            $table->string('actor', 160);
            $table->string('role', 32);
            $table->string('action', 64);
            $table->text('note')->nullable();
            $table->timestampsTz();

            $table->foreign('submission_id')
                ->references('id')
                ->on('thesis_submission')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_log');
    }
};
