<?php

use App\Enums\TopicStatus;
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
            CREATE TABLE IF NOT EXISTS topic_offer (
                id BIGSERIAL PRIMARY KEY,
                lecturer_id BIGINT NOT NULL REFERENCES lecturer(id) ON UPDATE CASCADE ON DELETE CASCADE,
                judul VARCHAR(150) NOT NULL,
                deskripsi TEXT NOT NULL,
                keywords TEXT[] NULL,
                prasyarat VARCHAR(255) NULL,
                kuota INT NOT NULL CHECK (kuota >= 0),
                bidang_id INT NOT NULL REFERENCES field_taxonomy(id) ON UPDATE CASCADE,
                status topic_status NOT NULL DEFAULT 'ACTIVE',
                created_at TIMESTAMPTZ NOT NULL DEFAULT now()
            );

            CREATE INDEX IF NOT EXISTS idx_topic_offer_lecturer ONtopic_offer(lecturer_id);
         */

        Schema::create('topic_offer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecturer_id');
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->text('keywords')->nullable();
            $table->string('prasyarat', 255)->nullable();
            $table->integer('kuota')->check('kuota >= 0');
            $table->foreignId('bidang_id');
            $table->enum('status', array_column(TopicStatus::cases(), 'value'))->default(TopicStatus::ACTIVE);
            $table->timestampsTz();

            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturer')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('bidang_id')
                ->references('id')
                ->on('field_taxonomy')
                ->onUpdate('cascade');

            $table->index('lecturer_id', 'idx_topic_offer_lecturer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_offer');
    }
};
