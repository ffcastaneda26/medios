        <nav class="bg-gray-900">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-3">
                    <!-- Botón Home -->
                    <a href="/"
                        class="flex-shrink-0 px-2 md:px-4 text-white hover:bg-gray-800 transition-colors rounded">
                        <i class="fas fa-home text-lg"></i>
                    </a>

                    <!-- Items de Categorías - Desktop -->
                    <div class="hidden md:flex items-center space-x-1 flex-1 justify-center overflow-x-auto">
                        @foreach ($categories as $category)
                            <a href="/{{ $category->slug }}"
                                class="px-4 py-3 text-white hover:bg-gray-800 transition-colors whitespace-nowrap text-sm font-medium uppercase rounded">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                    @include('partials.nav_botones_accion')
                </div>

                <!-- Menú Mobile -->
                <div id="mobile-menu" class="hidden md:hidden pb-4">
                    <div class="flex flex-col space-y-1">
                        @foreach ($categories as $category)
                            <a href="/{{ $category->slug }}"
                                class="px-4 py-3 text-white hover:bg-gray-800 transition-colors text-sm font-medium uppercase rounded">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                </div>
            </div>
        </nav>
