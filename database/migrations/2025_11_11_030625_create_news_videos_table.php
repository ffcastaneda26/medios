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
        Schema::create('news_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained()->onDelete('cascade')->comment('Noticia');
            $table->string('video_url')->comment('Liga URL del a imagen');
            $table->enum('video_type', ['youtube', 'vimeo', 'upload'])->default('youtube')->comment('Tipo de video');
            $table->string('title', 150)->nullable()->comment('Título');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_videos');
    }
};
