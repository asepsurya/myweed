<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->date('rsvp_deadline')->nullable();
            $table->text('rsvp_message')->nullable();
            $table->string('rsvp_whatsapp')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['rsvp_deadline', 'rsvp_message', 'rsvp_whatsapp']);
        });
    }
};
