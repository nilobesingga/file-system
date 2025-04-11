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
        if (!Schema::hasTable('investment')) {
            Schema::create('investment', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('investor_code');
                $table->string('investor_subaccount')->nullable();
                $table->string('investor_name');
                $table->decimal('monthly_distribution', 15, 2)->nullable();
                $table->string('bond_series')->nullable();
                $table->decimal('amount', 15, 2);
                $table->date('date');
                $table->string('transaction_type');
                $table->string('transaction');
                $table->string('month');
                $table->integer('year');
                $table->text('explanation')->nullable();
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment');
    }
};
