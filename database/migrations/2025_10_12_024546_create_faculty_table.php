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
                CREATE TABLE IF NOT EXISTS faculty (
                    id SERIAL PRIMARY KEY,
                    nama VARCHAR(120) NOT NULL UNIQUE
                );
             */

            Schema::create('faculty', function (Blueprint $table) {
                $table->id();
                $table->string('nama', 120)->unique();
                $table->timestampsTz();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('faculty');
        }
    };
