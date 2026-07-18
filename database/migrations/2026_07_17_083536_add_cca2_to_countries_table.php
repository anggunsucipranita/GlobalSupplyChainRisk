<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {

            $table->string('cca2',2)->after('cca3');

        });
    }

    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {

            $table->dropColumn('cca2');

        });
    }
};