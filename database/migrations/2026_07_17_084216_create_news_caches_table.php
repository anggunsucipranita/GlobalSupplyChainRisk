<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_caches', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                  ->nullable()
                  ->constrained('countries')
                  ->nullOnDelete();

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('image')->nullable();

            $table->text('url');

            $table->string('source')->nullable();

            $table->dateTime('published_at')->nullable();

            $table->string('sentiment')->nullable();

            $table->integer('positive')->default(0);

            $table->integer('negative')->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_caches');
    }
};