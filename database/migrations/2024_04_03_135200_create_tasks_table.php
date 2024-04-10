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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('name');
            $table->text('description');
            $table->date('start_date');
            $table->date('finnish_date');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->boolean('status')->default(false);

            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('set null');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
