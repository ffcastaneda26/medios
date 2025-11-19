            <nav class="bg-gray-900">
                <div class="container mx-auto px-4">
                    <div class="flex items-center justify-between overflow-x-auto">
                        <!-- Botón Home -->
                        <a href="/" class="flex-shrink-0 px-4 py-3 text-white hover:bg-gray-800 transition-colors">
                            <i class="fas fa-home text-lg"></i>
                        </a>

                        <!-- Items de Categorías -->
                        <div class="flex items-center space-x-1">
                            @foreach ($categories as $category)
                                <a href="/{{ $category->slug }}"
                                    class="px-4 py-3 text-white hover:bg-gray-800 transition-colors whitespace-nowrap text-sm font-medium uppercase">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Búsqueda (opcional) -->
                        <div class="flex-shrink-0 px-4">
                            <button class="text-white hover:text-gray-300">
                                <i class="fas fa-search text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
