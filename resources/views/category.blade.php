@extends('layouts.main')

@section('title', $category->name . ' - Portal de Noticias')

@section('content')
    <div class="space-y-6">

        <!-- Encabezado de Categoría -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
                    @if ($category->description)
                        <p class="text-gray-600">{{ $category->description }}</p>
                    @endif
                </div>
                <div class="text-gray-500">
                    <i class="fas fa-newspaper text-4xl"></i>
                </div>
            </div>
        </div>

        <!-- Banner de Patrocinadores -->
        @if ($sponsors->isNotEmpty())
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-center gap-6 overflow-x-auto">
                    @foreach ($sponsors->take(3) as $sponsor)
                        <a href="{{ $sponsor->website }}" target="_blank" class="flex-shrink-0">
                            <img src="{{ $sponsor->logo }}" alt="{{ $sponsor->name }}"
                                class="h-20 object-contain hover:opacity-80 transition-opacity">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Grid de Noticias -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Columna Principal - Noticias -->
            <div class="lg:col-span-2">
                @if ($news->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($news as $newsItem)
                            <x-news-card :news="$newsItem" variant="default" />
                        @endforeach
                    </div>

                    <!-- Paginación -->
                    <div class="mt-8">
                        {{ $news->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-600 mb-2">No hay noticias disponibles</h3>
                        <p class="text-gray-500">Aún no se han publicado noticias en esta categoría.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">

                <!-- Banner Vertical -->
                @if ($sponsors->count() > 3)
                    <div class="bg-white rounded-lg shadow-md p-4 sticky top-4">
                        <p class="text-xs text-gray-500 text-center mb-2">PUBLICIDAD</p>
                        <a href="{{ $sponsors->skip(3)->first()->website }}" target="_blank">
                            <img src="{{ $sponsors->skip(3)->first()->logo }}" alt="Patrocinador"
                                class="w-full h-auto object-contain hover:opacity-80 transition-opacity">
                        </a>
                    </div>
                @endif

                <!-- Otras Categorías -->
                {{-- <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 pb-2 border-b-2 border-red-600">Otras Secciones</h3>
                    <div class="space-y-2">
                        @foreach ($categories->where('id', '!=', $category->id) as $otherCategory)
                            <a href="/{{ $otherCategory->slug }}"
                                class="flex items-center justify-between py-2 px-3 rounded hover:bg-gray-100 transition-colors group">
                                <span class="font-medium text-gray-700 group-hover:text-red-600">
                                    {{ $otherCategory->name }}
                                </span>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-red-600"></i>
                            </a>
                        @endforeach
                    </div>
                </div> --}}

                <!-- Últimas Noticias Globales -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 pb-2 border-b-2 border-red-600">
                        <i class="fas fa-clock text-red-600 mr-2"></i>Últimas Noticias
                    </h3>
                    <div class="space-y-4">
                        @php
                            $latestNews = \App\Models\News::published()
                                ->with('category')
                                ->orderBy('published_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp

                        @foreach ($latestNews as $latest)
                            <article class="group cursor-pointer pb-4 border-b border-gray-200 last:border-b-0">
                                <a href="/noticia/{{ $latest->slug }}">
                                    <span class="text-red-600 text-xs font-bold uppercase block mb-1">
                                        {{ $latest->category->name }}
                                    </span>
                                    <h4
                                        class="font-semibold text-sm line-clamp-2 group-hover:text-red-600 transition-colors">
                                        {{ $latest->title }}
                                    </h4>
                                    <span class="text-gray-500 text-xs mt-1 inline-block">
                                        {{ $latest->published_at->diffForHumans() }}
                                    </span>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>

            </aside>
        </div>
    </div>
@endsection
