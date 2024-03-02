
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
        Schema::disableForeignKeyConstraints();

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->unique();
            $table->string('internal_serial')->nullable();
            $table->foreignId('device_id')->constrained();
            $table->foreignId('owner_id')->constrained('locations');
            $table->foreignId('location_id')->constrained('locations');
            $table->foreignId('status_id')->constrained();
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
