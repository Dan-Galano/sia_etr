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
        Schema::table('officers', function (Blueprint $table) {
            $table->boolean('is_current')->default(true)->after('photo'); // New column to indicate if the officer is current
            $table->year('term_start')->nullable()->after('is_current'); // New column for term start year
            $table->year('term_end')->nullable()->after('term_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            //
        });
    }
};
