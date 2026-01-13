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
        Schema::create('invitations', function (Blueprint $table) {
         $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();

            $table->string('slug')->unique();

            // Mempelai
            $table->string('groom_name');
            $table->string('groom_nickname')->nullable();
            $table->string('groom_father_name')->nullable();
            $table->string('groom_mother_name')->nullable();
            $table->string('foto_pria')->nullable();
            $table->string('foto_wanita')->nullable();
            $table->string('bride_name');
            $table->string('bride_nickname')->nullable();
            $table->string('bride_father_name')->nullable();
            $table->string('bride_mother_name')->nullable();

            // Acara
            $table->date('wedding_date');
            $table->string('akad_location')->nullable();
            $table->time('akad_time')->nullable();
            $table->string('akad_maps')->nullable();

            $table->string('resepsi_location')->nullable();
            $table->time('resepsi_time')->nullable();
            $table->string('resepsi_maps')->nullable();

            // Tema
            $table->string('theme_color')->nullable();
            $table->string('gallery_cover')->nullable();

            // Lainnya
            $table->text('wedding_quote')->nullable();
            $table->string('video_link')->nullable();
            $table->text('love_story')->nullable();

            // RSVP
            $table->boolean('enable_rsvp')->default(false);

            // Musik
            $table->string('music')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
