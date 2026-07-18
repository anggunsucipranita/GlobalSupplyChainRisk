<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_caches', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->double('temperature')->nullable();

            $table->double('wind_speed')->nullable();

            $table->double('rain')->default(0);

            $table->double('humidity')->nullable();

            $table->string('weather')->nullable();

            $table->timestamp('last_updated')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_caches');
    }
};