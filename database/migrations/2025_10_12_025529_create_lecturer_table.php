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
            CREATE TABLE IF NOT EXISTS lecturer (
                id BIGSERIAL PRIMARY KEY,
                nidn VARCHAR(32) NOT NULL UNIQUE,
                nama VARCHAR(120) NOT NULL,
                prodi_id INT NOT NULL REFERENCES program_study(id) ON UPDATE CASCADE,
                fakultas_id INT NOT NULL REFERENCES faculty(id) ON UPDATE CASCADE,
                email VARCHAR(160) NOT NULL,
                aktif BOOLEAN NOT NULL DEFAULT TRUE
            );
         */

        Schema::create('lecturer', function (Blueprint $table) {
            $table->id();
            $table->string('nidn', 32)->unique();
            $table->string('nama', 120);
            $table->foreignId('prodi_id');
            $table->foreignId('fakultas_id');
            $table->string('email', 160);
            $table->boolean('aktif')->default(true);
            $table->timestampsTz();

            $table->foreign('prodi_id')
                ->references('id')
                ->on('program_study')
                ->onUpdate('cascade');

            $table->foreign('fakultas_id')
                ->references('id')
                ->on('faculty')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer');
    }
};
