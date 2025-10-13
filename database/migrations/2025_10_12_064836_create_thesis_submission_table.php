<?php

use App\Enums\SubmissionStatus;
use App\Enums\SumberPengajuan;
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
            CREATE TABLE IF NOT EXISTS thesis_submission (
                id BIGSERIAL PRIMARY KEY,
                student_id BIGINT NOT NULL REFERENCES student(id) ON UPDATE CASCADE ON DELETE RESTRICT,
                semester VARCHAR(8) NOT NULL,
                sumber sumber_pengajuan NOT NULL,
                topic_offer_id BIGINT NULL REFERENCES topic_offer(id) ON UPDATE CASCADE ON DELETE SET NULL,
                topik_kategori VARCHAR(64) NOT NULL,
                judul VARCHAR(150) NOT NULL,
                abstrak TEXT NOT NULL,
                keywords TEXT[] NULL,
                status submission_status NOT NULL DEFAULT 'DIAJUKAN',
                created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
                UNIQUE (student_id, semester),
                CONSTRAINT chk_judul_len CHECK (char_length(judul) BETWEEN 10 AND 150)
            );

            CREATE INDEX IF NOT EXISTS idx_submission_status ON thesis_submission(status);
            CREATE INDEX IF NOT EXISTS idx_submission_created ON thesis_submission(created_at DESC);
         */

        Schema::create('thesis_submission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->string('semester', 8);
            $table->enum('sumber', array_column(SumberPengajuan::cases(), 'value'));
            $table->foreignId('topic_offer_id')->nullable();
            $table->string('topik_kategori', 64);
            $table->string('judul', 150);
            $table->text('abstrak');
            $table->text('keywords')->nullable()->array();
            $table->enum('status', array_column(SubmissionStatus::cases(), 'value'))->default(SubmissionStatus::DIAJUKAN);
            $table->timestampsTz();

            $table->foreign('student_id')
                ->references('id')
                ->on('student')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('topic_offer_id')
                ->references('id')
                ->on('topic_offer')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unique(['student_id', 'semester']);
            $table->index('status', 'idx_submission_status');
            $table->index('created_at', 'idx_submission_created');
        });

        DB::statement("ALTER TABLE topic_offer ADD CONSTRAINT chk_judul_len CHECK (char_length(judul) BETWEEN 10 AND 150)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE topic_offer DROP CONSTRAINT chk_judul_len");
        Schema::dropIfExists('thesis_submission');
    }
};
