<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('attendance', function (Blueprint $table) {
        // Change or add the studentid column as a VARCHAR(255)
        $table->string('studentid', 255); 
        
        // Set the foreign key constraint
        $table->foreign('studentid')->references('studentid')->on('enrolled_students')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['studentid']);
            $table->dropColumn('studentid');
        });
    }
};
