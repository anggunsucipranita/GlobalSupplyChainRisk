<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_scores', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                  ->constrained('countries')
                  ->cascadeOnDelete();

            $table->integer('weather_risk')->default(0);

            $table->integer('economy_risk')->default(0);

            $table->integer('currency_risk')->default(0);

            $table->integer('news_risk')->default(0);

            $table->integer('port_risk')->default(0);

            $table->integer('overall_risk')->default(0);

            $table->enum('risk_level',[
                'Low',
                'Medium',
                'High'
            ])->default('Low');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_scores');
    }
};