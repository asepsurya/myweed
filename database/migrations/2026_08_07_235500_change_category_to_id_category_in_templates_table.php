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
            $table->unsignedBigInteger('id_category')->nullable()->after('slug');
        });

        $categories = DB::table('categories')->get();
        foreach ($categories as $cat) {
            DB::table('templates')->where('category', $cat->name)->update(['id_category' => $cat->id]);
        }

        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->string('category')->default('Wedding')->after('slug');
        });

        $categories = DB::table('categories')->get();
        foreach ($categories as $cat) {
            DB::table('templates')->where('id_category', $cat->id)->update(['category' => $cat->name]);
        }

        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign(['id_category']);
            $table->dropColumn('id_category');
        });
    }
};
