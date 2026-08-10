<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weeding_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invitation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('task_name');
            $table->text('description')->nullable();
            $table->string('category')->default('persiapan');
            $table->date('due_date')->nullable();
            $table->string('status')->default('pending');
            $table->string('priority')->default('medium');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['invitation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weeding_plans');
    }
};
