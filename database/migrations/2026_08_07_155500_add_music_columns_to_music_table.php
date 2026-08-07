<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('music', function (Blueprint $table) {
            $table->string('album')->nullable()->after('artist');
            $table->string('music_url')->nullable()->after('cover_url');
            $table->unsignedBigInteger('file_size')->nullable()->after('duration');
            $table->string('mime_type')->nullable()->after('file_size');
        });
    }

    public function down(): void
    {
        Schema::table('music', function (Blueprint $table) {
            $table->dropColumn(['album', 'music_url', 'file_size', 'mime_type']);
        });
    }
};
