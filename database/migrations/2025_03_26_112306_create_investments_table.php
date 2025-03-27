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
        Schema::create('investment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('investment_type'); // Stocks, Bonds, Mutual Funds, Real Estate
            $table->decimal('investment_amount', 15, 2);
            $table->integer('number_of_units')->nullable(); // Number of stocks, bonds, etc.
            $table->decimal('interest_rate', 5, 2)->nullable(); // Applicable for Bonds
            $table->date('investment_date');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment');
    }
};
