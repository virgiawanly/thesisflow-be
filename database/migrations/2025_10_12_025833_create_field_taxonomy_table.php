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
            CREATE TABLE IF NOT EXISTS field_taxonomy (
                id SERIAL PRIMARY KEY,
                nama VARCHAR(80) NOT NULL,
                parent_id INT NULL REFERENCES field_taxonomy(id) ON UPDATE CASCADE ON DELETE SET NULL,
                UNIQUE(nama, parent_id)
            );
         */

        Schema::create('field_taxonomy', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 80);
            $table->foreignId('parent_id')->nullable();
            $table->timestampsTz();

            $table->foreign('parent_id')
                ->references('id')
                ->on('field_taxonomy')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unique(['nama', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_taxonomy');
    }
};
