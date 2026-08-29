<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('phone', 20);
            $table->timestamps();

            $table->index(['user_id', 'phone']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
