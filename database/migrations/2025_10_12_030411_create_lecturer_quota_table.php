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
            CREATE TABLE IF NOT EXISTS lecturer_quota (
                lecturer_id BIGINT NOT NULL REFERENCES lecturer(id) ON UPDATE CASCADE ON DELETE CASCADE,
                semester VARCHAR(8) NOT NULL,
                kuota_max INT NOT NULL CHECK (kuota_max >= 0),
                PRIMARY KEY (lecturer_id, semester)
            );
         */

        Schema::create('lecturer_quota', function (Blueprint $table) {
            $table->foreignId('lecturer_id');
            $table->string('semester', 8);
            $table->integer('kuota_max')->check('kuota_max >= 0');

            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturer')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['lecturer_id', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_quota');
    }
};
