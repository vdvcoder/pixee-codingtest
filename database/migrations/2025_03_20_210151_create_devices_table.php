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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('device_type');
            $table->string('mac_address')->unique();
            $table->string('ip_address')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('rotation')->nullable();
            $table->timestamp('last_ping')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices'); // Ensure the column 'name' is used in the 'up' method
    }
};
