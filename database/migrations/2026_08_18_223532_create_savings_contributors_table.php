<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings_contributors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('relationship')->nullable();
            $table->boolean('is_external')->default(false);
            $table->timestamps();

            $table->index(['invitation_id']);
            $table->unique(['invitation_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings_contributors');
    }
};
