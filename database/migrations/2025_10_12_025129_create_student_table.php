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
            CREATE TABLE IF NOT EXISTS student (
                id BIGSERIAL PRIMARY KEY,
                nrp VARCHAR(32) NOT NULL UNIQUE,
                nama VARCHAR(120) NOT NULL,
                prodi_id INT NOT NULL REFERENCES program_study(id) ON UPDATE CASCADE,
                fakultas_id INT NOT NULL REFERENCES faculty(id) ON UPDATE CASCADE,
                status_akademik VARCHAR(32) NOT NULL,
                status_keuangan VARCHAR(32) NOT NULL,
                total_sks SMALLINT NOT NULL DEFAULT 0 CHECK (total_sks >= 0),
                ipk NUMERIC(3,2) NOT NULL DEFAULT 0 CHECK (ipk >= 0 AND ipk <= 4),
                angkatan SMALLINT NOT NULL
            );
         */

        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('nrp', 32)->unique();
            $table->string('nama', 120);
            $table->foreignId('prodi_id');
            $table->foreignId('fakultas_id');
            $table->string('status_akademik', 32);
            $table->string('status_keuangan', 32);
            $table->smallInteger('total_sks')->default(0)->check('total_sks >= 0');
            $table->decimal('ipk', 3, 2)->default(0)->check('ipk >= 0 AND ipk <= 4');
            $table->smallInteger('angkatan');
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
        Schema::dropIfExists('student');
    }
};
