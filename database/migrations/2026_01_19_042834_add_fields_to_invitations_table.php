<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
             $table->string('bride_username_instagram')->nullable();
             $table->string('groom_username_instagram')->nullable();
             $table->string('akad_address')->nullable();
             $table->string('resepsi_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('bride_username_instagram');
            $table->dropColumn('groom_username_instagram');
            $table->dropColumn('akad_address');
            $table->dropColumn('resepsi_address');
        });
    }
};
