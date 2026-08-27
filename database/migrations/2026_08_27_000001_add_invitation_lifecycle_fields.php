<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            Schema::table('invitations', function (Blueprint $table) {
                $table->timestamp('expired_at')->nullable()->after('status');
                $table->timestamp('retention_until')->nullable()->after('expired_at');
                $table->timestamp('deletion_started_at')->nullable()->after('retention_until');
                $table->timestamp('deletion_completed_at')->nullable()->after('deletion_started_at');
                $table->unsignedInteger('deletion_attempts')->default(0)->after('deletion_completed_at');
                $table->text('deletion_error')->nullable()->after('deletion_attempts');
                $table->index(['status', 'retention_until'], 'invitations_status_retention_idx');
            });

            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE invitations MODIFY COLUMN status ENUM('draft', 'published', 'expired', 'trash') DEFAULT 'draft'"
            );

            return;
        }

        Schema::table('invitations', function (Blueprint $table) {
            $table->string('status_tmp', 20)->default('draft')->after('music');
        });

        \Illuminate\Support\Facades\DB::table('invitations')->update([
            'status_tmp' => \Illuminate\Support\Facades\DB::raw('status'),
        ]);

        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });

        Schema::table('invitations', function (Blueprint $table) {
            $table->string('status', 20)->default('draft')->after('music');
        });

        \Illuminate\Support\Facades\DB::table('invitations')->whereNotNull('status_tmp')->update([
            'status' => \Illuminate\Support\Facades\DB::raw('status_tmp'),
        ]);

        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('status_tmp');
        });

        Schema::table('invitations', function (Blueprint $table) {
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('retention_until')->nullable();
            $table->timestamp('deletion_started_at')->nullable();
            $table->timestamp('deletion_completed_at')->nullable();
            $table->unsignedInteger('deletion_attempts')->default(0);
            $table->text('deletion_error')->nullable();
            $table->index(['status', 'retention_until'], 'invitations_status_retention_idx');
        });
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        Schema::table('invitations', function (Blueprint $table) {
            $table->dropIndex('invitations_status_retention_idx');
            $table->dropColumn([
                'expired_at',
                'retention_until',
                'deletion_started_at',
                'deletion_completed_at',
                'deletion_attempts',
                'deletion_error',
            ]);
        });

        if ($driver === 'mysql') {
            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE invitations MODIFY COLUMN status ENUM('draft', 'published') DEFAULT 'draft'"
            );
        }
    }
};
