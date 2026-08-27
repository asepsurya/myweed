<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('enable_gallery')->default(true)->after('enable_gift');
            $table->boolean('enable_music')->default(true)->after('enable_gallery');
            $table->boolean('enable_video')->default(true)->after('enable_music');
            $table->boolean('enable_love_story')->default(true)->after('enable_video');
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE invitations MODIFY COLUMN enable_gift BOOLEAN DEFAULT TRUE');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE invitations MODIFY COLUMN enable_rsvp BOOLEAN DEFAULT TRUE');
        }
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['enable_gallery', 'enable_music', 'enable_video', 'enable_love_story']);
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE invitations MODIFY COLUMN enable_gift VARCHAR NULL');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE invitations MODIFY COLUMN enable_rsvp BOOLEAN DEFAULT FALSE');
        }
    }
};
