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
        if (Schema::hasTable('files')) {
            Schema::table('files', function (Blueprint $table) {
                $table->string('document_type')->default('Bond')->comment('Bond,Stock')->after('document_name');
                $table->string('statement_no')->nullable()->after('user_id');
                $table->string('statement_period')->nullable()->after('statement_no');
                $table->integer('number_of_bonds')->nullable()->after('statement_period');
                $table->decimal('amount_subscribed', 15, 2)->nullable()->after('number_of_bonds');
                $table->string('currency', 3)->nullable()->after('amount_subscribed');
                $table->bigInteger('created_by')->nullable()->after('currency');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
