<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('co_workers_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('co_worker_id')->constrained('co_workers')->onDelete('cascade');
            $table->foreignId('partner_id')->constrained('partners')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('co_workers_partners');
    }
};
