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
        if (!Schema::hasTable('investment_statistics')) {
            Schema::create('investment_statistics', function (Blueprint $table) {
                $table->id();
                $table->foreignId('investment_id')->constrained()->onDelete('cascade');
                $table->decimal('monthly_investment', 15, 2);
                $table->decimal('monthly_interest', 15, 2)->nullable();
                $table->date('month');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_statistics');
    }
};
