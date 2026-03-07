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
        Schema::table('divisions', function (Blueprint $table) {
        $table->string('superior_division')->nullable(); // Agrega la columna 'superior_division' como nullable
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('divisions', function (Blueprint $table) {
        $table->dropColumn('superior_division');
    });
    }
};
