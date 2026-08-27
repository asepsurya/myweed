<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_plan_id')->nullable()->after('type');
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->nullOnDelete();
            $table->string('type', 20)->default('percentage')->change();
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign(['subscription_plan_id']);
            $table->dropColumn('subscription_plan_id');
            $table->enum('type', ['percentage', 'fixed'])->default('percentage')->change();
        });
    }
};
