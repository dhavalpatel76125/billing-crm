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
        Schema::table('balance_sheets', function (Blueprint $table) {
            $table->text('remarks')->nullable();
            $table->decimal('last_credit_amount', 10, 2)->nullable();
            $table->timestamp('last_credit_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balance_sheets', function (Blueprint $table) {
            $table->dropColumn(['remarks', 'last_credit_amount', 'last_credit_updated_at']);
        });
    }
};
