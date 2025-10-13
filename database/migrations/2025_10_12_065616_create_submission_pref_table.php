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
            CREATE TABLE IF NOT EXISTS submission_pref (
                submission_id BIGINT NOT NULL REFERENCES thesis_submission(id) ON UPDATE CASCADE ON DELETE CASCADE,
                lecturer_id BIGINT NOT NULL REFERENCES lecturer(id) ON UPDATE CASCADE ON DELETE RESTRICT,
                urutan SMALLINT NOT NULL CHECK (urutan BETWEEN 1 AND 3),
                PRIMARY KEY (submission_id, lecturer_id),
                UNIQUE (submission_id, urutan)
            );
         */

        Schema::create('submission_pref', function (Blueprint $table) {
            $table->foreignId('submission_id');
            $table->foreignId('lecturer_id');
            $table->smallInteger('urutan')->check('urutan BETWEEN 1 AND 3');

            $table->foreign('submission_id')
                ->references('id')
                ->on('thesis_submission')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturer')
                ->onUpdate('cascade');

            $table->primary(['submission_id', 'lecturer_id']);
            $table->unique(['submission_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_pref');
    }
};
