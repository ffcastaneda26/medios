    <header class="bg-white shadow-md">
        <!-- Primera fila del Header -->
        <div class="border-b border-gray-200">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center">
                            <img src="{{ Storage::url($contactInfo->logo) }}" alt="Logo" class="h-12 md:h-24">
                        </a>
                    </div>

                    <!-- Widget a la derecha -->
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-3">
                            @include('partials.widget_fecha_hora')
                            @include('partials.widget_temperatura')
                            @include('partials.widget_tipo_cambio')
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Segunda fila del Header - Navegación de Categorías -->
        @include('partials.categories_nav')
    </header>
