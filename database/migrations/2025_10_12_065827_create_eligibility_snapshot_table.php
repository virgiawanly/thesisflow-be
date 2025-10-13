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
            CREATE TABLE IF NOT EXISTS eligibility_snapshot (
                submission_id BIGINT PRIMARY KEY REFERENCES thesis_submission(id) ON UPDATE CASCADE ON DELETE CASCADE,
                total_sks SMALLINT NOT NULL CHECK (total_sks >= 0),
                ipk NUMERIC(3,2) NOT NULL CHECK (ipk >= 0 AND ipk <= 4),
                status_akademik VARCHAR(32) NOT NULL,
                status_keuangan VARCHAR(32) NOT NULL,
                prasyarat_ok BOOLEAN NOT NULL,
                snapshot_at TIMESTAMPTZ NOT NULL DEFAULT now()
            );
         */

        Schema::create('eligibility_snapshot', function (Blueprint $table) {
            $table->foreignId('submission_id')->primary();
            $table->smallInteger('total_sks')->check('total_sks >= 0');
            $table->decimal('ipk', 3, 2)->check('ipk >= 0 AND ipk <= 4');
            $table->string('status_akademik', 32);
            $table->string('status_keuangan', 32);
            $table->boolean('prasyarat_ok');
            $table->timestampTz('snapshot_at')->default(now());
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
        Schema::dropIfExists('eligibility_snapshot');
    }
};
