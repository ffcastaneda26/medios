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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('');
            $table->enum('type', ['weather', 'clock', 'social', 'custom', 'newsletter'])->comment('Tipo de Widget');
            $table->string('position', 20)->default('sidebar')->comment('Posición'); // sidebar, footer, header
            $table->json('config')->nullable()->comment('Configuración variable');
            $table->boolean('is_active')->default(true)->comment('¿Activo?');
            $table->integer('order')->default(0)->comment('Orden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
