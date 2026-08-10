<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->after('id');
            $table->boolean('is_user_template')->default(false)->after('is_active');
            $table->string('parent_template')->nullable()->after('is_user_template');
            $table->json('ai_prompt')->nullable()->after('parent_template');
            $table->text('description')->nullable()->after('ai_prompt');
        });
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'is_user_template', 'parent_template', 'ai_prompt', 'description']);
        });
    }
};
