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
            CREATE TABLE IF NOT EXISTS notification (
                id BIGSERIAL PRIMARY KEY,
                user_ref VARCHAR(160) NOT NULL,
                channel VARCHAR(16) NOT NULL CHECK (channel IN ('email','inapp')),
                title VARCHAR(120) NOT NULL,
                message TEXT NOT NULL,
                sent_at TIMESTAMPTZ NULL,
                status VARCHAR(16) NOT NULL DEFAULT 'queued'
            );
         */

        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->string('user_ref', 160);
            $table->string('channel', 16)->check('channel IN (\'email\', \'inapp\')');
            $table->string('title', 120);
            $table->text('message');
            $table->timestampTz('sent_at')->nullable();
            $table->string('status', 16)->default('queued');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
