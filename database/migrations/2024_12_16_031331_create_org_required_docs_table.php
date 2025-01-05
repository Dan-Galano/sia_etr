<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgRequiredDocsTable extends Migration
{
    public function up()
    {
        Schema::create('org_required_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_org_id')->constrained('school_organizations')->onDelete('cascade');
            $table->string('doc_filename');
            $table->enum('status', ['pending', 'reaccreditation', 'other'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('org_required_docs');
    }
}
