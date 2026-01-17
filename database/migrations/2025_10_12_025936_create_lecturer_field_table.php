<?php

use App\Enums\LevelKeahlian;
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
             CREATE TABLE IF NOT EXISTS lecturer_field (
                lecturer_id BIGINT NOT NULL REFERENCES lecturer(id) ON UPDATE CASCADE ON DELETE CASCADE,
                bidang_id INT NOT NULL REFERENCES field_taxonomy(id) ON UPDATE CASCADE ON DELETE RESTRICT,
                level level_keahlian NULL,
                PRIMARY KEY (lecturer_id, bidang_id)
            );
         */

        Schema::create('lecturer_field', function (Blueprint $table) {
            $table->foreignId('lecturer_id');
            $table->foreignId('bidang_id');
            $table->enum('level_keahlian', array_column(LevelKeahlian::cases(), 'value'))->nullable();

            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturer')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('bidang_id')
                ->references('id')
                ->on('field_taxonomy')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['lecturer_id', 'bidang_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_field');
    }
};
