{{-- resources/views/components/advertisement.blade.php --}}
@props(['ad', 'class' => ''])

@if ($ad)
    <div class="advertisement {{ $class }}" data-ad-id="{{ $ad->id }}">
        @if ($ad->ad_type === 'banner')
            {{-- Banner: Imagen horizontal --}}
            <a href="/ad/click/{{ $ad->id }}" target="_blank" class="block hover:opacity-90 transition-opacity">
                @if (isset($ad->content['image']))
                    <img src="{{ Storage::url($ad->content['image']) }}" alt="{{ $ad->title }}"
                        class="w-full h-auto rounded-lg shadow-sm">
                @else
                    <div class="bg-gray-200 p-8 text-center rounded-lg">
                        <p class="text-gray-600">{{ $ad->title }}</p>
                        <small class="text-gray-500">Banner: {{ $ad->sponsor->name }}</small>
                    </div>
                @endif
            </a>
        @elseif($ad->ad_type === 'sidebar')
            {{-- Sidebar: Imagen vertical o cuadrada --}}
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-xs text-gray-500 text-center mb-2">PUBLICIDAD</p>
                <a href="/ad/click/{{ $ad->id }}" target="_blank"
                    class="block hover:opacity-90 transition-opacity">
                    @if (isset($ad->content['image']))
                        <img src="{{ Storage::url($ad->content['image']) }}" alt="{{ $ad->title }}"
                            class="w-full h-auto object-contain">
                    @else
                        <div class="bg-gray-200 p-8 text-center">
                            <p class="text-gray-600 font-semibold">{{ $ad->title }}</p>
                            <small class="text-gray-500">{{ $ad->sponsor->name }}</small>
                        </div>
                    @endif
                </a>
                @if (isset($ad->content['description']))
                    <p class="text-sm text-gray-600 mt-3">{{ $ad->content['description'] }}</p>
                @endif
            </div>
        @elseif($ad->ad_type === 'native')
            {{-- Nativo: Se integra con el contenido --}}
            <article class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
                <a href="/ad/click/{{ $ad->id }}" target="_blank" class="block group">
                    @if (isset($ad->content['image']))
                        <div class="relative overflow-hidden h-48">
                            <img src="{{ Storage::url($ad->content['image']) }}" alt="{{ $ad->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <span class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                Patrocinado
                            </span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $ad->title }}
                        </h3>
                        @if (isset($ad->content['description']))
                            <p class="text-gray-600 text-sm mb-3">{{ $ad->content['description'] }}</p>
                        @endif
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $ad->sponsor->name }}</span>
                            <span class="text-blue-500">Leer más →</span>
                        </div>
                    </div>
                </a>
            </article>
        @elseif($ad->ad_type === 'popup')
            {{-- Popup: Modal que aparece después de cierto tiempo --}}
            <div id="popup-{{ $ad->id }}"
                class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
                x-data="{ show: false }" x-show="show" x-init="setTimeout(() => show = true, {{ $ad->content['delay'] ?? 5000 }})">
                <div class="bg-white rounded-lg max-w-2xl w-full relative" @click.away="show = false">
                    <button @click="show = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">
                        ×
                    </button>
                    <a href="/ad/click/{{ $ad->id }}" target="_blank">
                        @if (isset($ad->content['image']))
                            <img src="{{ Storage::url($ad->content['image']) }}" alt="{{ $ad->title }}"
                                class="w-full rounded-t-lg">
                        @endif
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2">{{ $ad->title }}</h3>
                            @if (isset($ad->content['description']))
                                <p class="text-gray-600 mb-4">{{ $ad->content['description'] }}</p>
                            @endif
                            <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                {{ $ad->content['button_text'] ?? 'Ver más' }}
                            </button>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- Script para registrar impresión --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ad = document.querySelector('[data-ad-id="{{ $ad->id }}"]');
            if (ad) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            fetch('/ad/impression/{{ $ad->id }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            });
                            observer.unobserve(ad);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                observer.observe(ad);
            }
        });
    </script>
@endif
