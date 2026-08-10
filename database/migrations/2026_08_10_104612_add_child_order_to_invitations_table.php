<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('groom_child_order')->nullable()->after('groom_mother_name');
            $table->string('bride_child_order')->nullable()->after('bride_mother_name');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['groom_child_order', 'bride_child_order']);
        });
    }
};
