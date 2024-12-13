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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['text', 'withphoto', 'event', 'eventwithphoto']);
            $table->enum('privacy', ['public', 'private'])->default('private');
            $table->text('content')->nullable();
            $table->string('event_title')->nullable();
            $table->dateTime('event_start_time')->nullable();
            $table->dateTime('event_end_time')->nullable();
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('school_organizations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
