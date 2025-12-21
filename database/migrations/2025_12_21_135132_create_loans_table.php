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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->boolean('is_complete')->default(false);
            $table->string('status')->default('Draft');
            $table->date('start_date');
            $table->date('due_date')->nullable();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('guarantor_name')->nullable();
            $table->string('issuer')->default('Personal Loan');
            $table->string('loan_type')->default('DBL');
            $table->decimal('principal_amount', 15, 2);
            $table->decimal('interest_rate_monthly', 8, 4);
            $table->decimal('disbursement_amount', 15, 2)->nullable();
            $table->text('description')->nullable();
            $table->integer('terms_months');
            $table->decimal('additional_fees', 15, 2)->default(0);
            $table->decimal('advance_payment', 15, 2)->default(0);
            $table->text('feature_applied')->nullable();
            $table->text('notes')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
