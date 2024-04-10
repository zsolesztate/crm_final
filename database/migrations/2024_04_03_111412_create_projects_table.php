<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->string('name');
            $table->text('description');

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
