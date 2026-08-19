<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('savings_contributions', function (Blueprint $table) {
            $table->foreignId('savings_contributor_id')->nullable()->after('invitation_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('savings_contributions', function (Blueprint $table) {
            $table->dropForeign(['savings_contributor_id']);
            $table->dropColumn('savings_contributor_id');
        });
    }
};
