<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->string('invitation_type', 50)->default('wedding')->after('template_type_id');
        });

        DB::statement("UPDATE templates SET invitation_type = 'wedding' WHERE invitation_type IS NULL OR invitation_type = ''");
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('invitation_type');
        });
    }
};
