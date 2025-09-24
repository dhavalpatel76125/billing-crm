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
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relations
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('invoice_id')->nullable()->index();

            // Debit or Credit
            $table->enum('side', ['debit', 'credit']);

            // Amount
            $table->decimal('amount', 15, 2);

            // Allocated means: if this credit is linked to an invoice (1) or unapplied (0)
            $table->boolean('allocated')->default(false);

            // Notes
            $table->string('remarks')->nullable();

            // Date of the entry (important for ordering in ledger)
            $table->timestamp('entry_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};
