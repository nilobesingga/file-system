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
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('investor_code');
                $table->string('month');
                $table->integer('year');
                $table->decimal('capital',15,2);
                $table->decimal('investor_assets', 15, 2);
                $table->decimal('capital_gain_loss',15,2);
                $table->decimal('monthly_net_gain_loss', 15, 2);
                $table->decimal('fees', 15, 2);
                $table->decimal('payment_distribution', 15, 2);
                $table->decimal('monthly_net_percentage', 5, 2);
                $table->integer('number_of_bonds');
                $table->decimal('ending_balance',15,2)->nullable();
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
