<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('vendor_name', 255);
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('expense_date');
            $table->string('payment_method', 20)->default('cash');
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->boolean('is_paid')->default(true);
            $table->timestamps();

            $table->index(['budget_category_id']);
            $table->index(['invitation_id']);
            $table->index(['user_id', 'expense_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_expenses');
    }
};
