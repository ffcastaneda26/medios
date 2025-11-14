<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained()->onDelete('cascade')->comment('Patrocinador');
            $table->string('title', 150)->comment('Título');
            $table->enum('ad_type', ['image', 'text', 'video', 'banner', 'html'])->comment('Tipo');
            $table->json('content')->comment('Contenido flexible'); // Flexible para diferentes tipos
            $table->string('position', 25)->comment('Posición: header, sidebar,footer,inline...'); // header, sidebar, footer, inline-1, inline-2, etc.
            $table->string('click_url')->nullable()->comment('Liga URL');
            $table->unsignedBigInteger('impressions_count')->default(0)->comment('Contador de impresiones');
            $table->unsignedBigInteger('clicks_count')->default(0)->comment('Conteo de Clicks');
            $table->enum('status', ['active', 'inactive', 'scheduled'])->default('active')->comment('Estado');
            $table->timestamp('start_date')->nullable()->comment('Inicia el día');
            $table->timestamp('end_date')->nullable()->comment('Finaliza el día');
            $table->integer('priority')->default(0)->comment('Prioridad');
            $table->timestamps();

            $table->index(['status', 'position']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
