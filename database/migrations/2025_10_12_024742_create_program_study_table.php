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
            CREATE TABLE IF NOT EXISTS program_study (
                id SERIAL PRIMARY KEY,
                nama VARCHAR(120) NOT NULL,
                fakultas_id INT NOT NULL REFERENCES faculty(id) ON UPDATE CASCADE ON DELETE RESTRICT,
                UNIQUE(nama, fakultas_id)
            );
         */

        Schema::create('program_study', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120);
            $table->foreignId('fakultas_id');
            $table->timestampsTz();

            $table->foreign('fakultas_id')
                ->references('id')
                ->on('faculty')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->unique(['nama', 'fakultas_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_study');
    }
};
