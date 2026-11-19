<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('guest_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('guest_name');
            $table->string('device_id');
            $table->string('image_url');
            $table->timestamp('created_at')->useCurrent();

            $table->index('event_id');
            $table->index(['event_id', 'device_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_photos');
    }
};