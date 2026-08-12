<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->foreignId('partner_user_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();
            $table->string('partner_invite_token', 64)->nullable()->after('partner_user_id');
            $table->timestamp('partner_accepted_at')->nullable()->after('partner_invite_token');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropForeign(['partner_user_id']);
            $table->dropColumn(['partner_user_id', 'partner_invite_token', 'partner_accepted_at']);
        });
    }
};
