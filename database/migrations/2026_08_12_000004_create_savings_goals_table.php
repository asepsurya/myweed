<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 255);
            $table->decimal('target_amount', 15, 2)->default(0);
            $table->string('currency', 3)->default('IDR');
            $table->date('deadline');
            $table->string('colour', 7)->default('#C6A962');
            $table->text('description')->nullable();
            $table->json('auto_savings_rule')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_shared')->default(true);
            $table->timestamps();

            $table->index(['invitation_id']);
            $table->index(['user_id', 'deadline']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings_goals');
    }
};
