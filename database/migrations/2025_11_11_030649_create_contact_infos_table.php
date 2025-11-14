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
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20)->nullable()->comment('Teléfono');
            $table->string('email')->nullable()->comment('Correo Electrónico');
            $table->text('address', 100)->nullable()->comment('Dirección');
            $table->string('social_facebook', 100)->nullable()->comment('Facebook');
            $table->string('social_instagram', 100)->nullable()->comment('Instagram');
            $table->string('social_tiktok', 100)->nullable()->comment('Tiktok');
            $table->string('social_twitter', 100)->nullable()->comment('Twitter (X)');
            $table->string('social_youtube', 100)->nullable()->comment('Youtube');
            $table->text('about_text')->nullable()->comment('Acerca de nosotros');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
