<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('savings_contributors', function (Blueprint $table) {
            $table->string('invite_token')->nullable()->after('is_external');
            $table->string('invite_email')->nullable()->after('invite_token');
            $table->timestamp('invited_at')->nullable()->after('invite_email');
            $table->timestamp('accepted_at')->nullable()->after('invited_at');
            $table->boolean('can_edit')->default(true)->after('accepted_at');
        });
    }

    public function down(): void
    {
        Schema::table('savings_contributors', function (Blueprint $table) {
            $table->dropColumn(['invite_token', 'invite_email', 'invited_at', 'accepted_at', 'can_edit']);
        });
    }
};
