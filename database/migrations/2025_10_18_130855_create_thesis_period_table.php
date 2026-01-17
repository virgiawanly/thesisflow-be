<?php

use App\Enums\ThesisPeriodStage;
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
        Schema::create('thesis_period', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id');
            $table->string('semester', 8);
            $table->enum('stage', array_column(ThesisPeriodStage::cases(), 'value'));
            $table->timestampTz('start_at')->nullable();
            $table->timestampTz('end_at')->nullable();
            $table->timestampsTz();

            $table->foreign('prodi_id')
                ->references('id')
                ->on('program_study')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_period');
    }
};
