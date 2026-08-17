<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('invitation_type', 50)->default('wedding')->after('theme_type');
        });

        \Illuminate\Support\Facades\DB::statement("UPDATE invitations SET invitation_type = 'wedding' WHERE invitation_type IS NULL OR invitation_type = ''");
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('invitation_type');
        });
    }
};
