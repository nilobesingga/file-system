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
        Schema::create('statement_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statement_id')->constrained()->onDelete('cascade');
            $table->string('statement_no')->nullable();
            $table->foreignId('investor_code')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statement_series');
    }
};
