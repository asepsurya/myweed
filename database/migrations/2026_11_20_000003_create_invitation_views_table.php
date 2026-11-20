<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('visitor_hash', 64)->nullable();
            $table->timestamps();

            $table->index(['invitation_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_views');
    }
};