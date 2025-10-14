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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')
                ->on('student')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturer')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('prodi_id')
                ->references('id')
                ->on('program_study')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('fakultas_id')
                ->references('id')
                ->on('faculty')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['lecturer_id']);
            $table->dropForeign(['prodi_id']);
            $table->dropForeign(['fakultas_id']);
        });
    }
};
