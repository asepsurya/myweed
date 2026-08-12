<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('savings_goal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contributor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('currency', 3)->default('IDR');
            $table->string('method', 20)->default('transfer');
            $table->timestamp('contributed_at');
            $table->string('note', 500)->nullable();
            $table->boolean('is_automatic')->default(false);
            $table->timestamps();

            $table->index(['savings_goal_id']);
            $table->index(['invitation_id']);
            $table->index(['contributor_id']);
            $table->index(['contributed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings_contributions');
    }
};
