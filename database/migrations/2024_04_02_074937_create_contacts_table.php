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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('position');
            $table->unsignedBigInteger('partner_id');
            $table->boolean('primary_contact')->default(false);

            $table->foreign('partner_id')->references('id')->on('partners');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
