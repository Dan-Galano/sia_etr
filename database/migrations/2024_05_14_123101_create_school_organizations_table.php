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
        Schema::create('school_organizations', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'approved', 'rejected', 'reaccred'])->default('pending');
            $table->string('orgname');
            $table->string('course');
            $table->text('bio');
            $table->text('contact')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('twitter')->nullable();
            $table->text('tiktok')->nullable();
            $table->text('youtube')->nullable();
            $table->string('coverphoto');
            $table->unsignedBigInteger('admin_id');
            $table->timestamps();
            
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_organizations');
    }
};
