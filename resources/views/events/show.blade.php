<x-public-layout>
    <x-slot name="title">{{ $event['name'] }} - Мероприятия - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Breadcrumbs -->
        <section class="bg-gray-50 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                    <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    <span class="sr-only">Главная</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ route('events') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Мероприятия
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">
                                    {{ Str::limit($event['name'], 30) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Event Header -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        {{ $event['name'] }}
                    </h1>
                    <div class="flex items-center justify-center space-x-4 text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ count($event['images']) }} фотографий</span>
                        </div>
                        @if(count($event['branches']) > 0)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>{{ count($event['branches']) }} отделений участвовало</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Event Content -->
        <section class="pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- Description -->
                        @if($event['description'])
                            <div class="mb-12">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">О мероприятии</h2>
                                <div class="prose prose-lg max-w-none">
                                    {!! nl2br(e($event['description'])) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Photo Gallery -->
                        @if(count($event['images']) > 0)
                            <div class="mb-12">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Фотогалерея</h2>
                                
                                <!-- Image Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="photo-gallery">
                                    @foreach($event['images'] as $index => $image)
                                        <div class="relative group cursor-pointer" onclick="openLightbox({{ $index }})">
                                            <img src="{{ asset($image['path']) }}" 
                                                 alt="{{ $image['caption'] }}" 
                                                 class="w-full h-48 object-cover rounded-lg shadow-sm group-hover:shadow-lg transition-shadow">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                </svg>
                                            </div>
                                            <div class="absolute bottom-2 left-2 right-2">
                                                <p class="text-white text-sm bg-black bg-opacity-50 px-2 py-1 rounded truncate">
                                                    {{ $image['caption'] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Lightbox -->
                            <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center">
                                <div class="relative max-w-4xl max-h-full p-4">
                                    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain">
                                    <div class="absolute bottom-4 left-4 right-4 text-center">
                                        <p id="lightbox-caption" class="text-white text-lg bg-black bg-opacity-50 px-4 py-2 rounded"></p>
                                    </div>
                                    <button onclick="previousImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    <button onclick="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-6 sticky top-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Информация о мероприятии</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Фотографий</h4>
                                    <p class="text-gray-600">{{ count($event['images']) }}</p>
                                </div>

                                @if(count($event['branches']) > 0)
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Участвующие отделения</h4>
                                        <div class="space-y-2">
                                            @foreach($event['branches'] as $branch)
                                                <div class="text-sm">
                                                    <a href="{{ route('branches.show', $branch) }}" class="text-blue-600 hover:text-blue-700">
                                                        {{ $branch->name }}
                                                    </a>
                                                    <p class="text-gray-500">{{ $branch->region }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="border-t border-gray-200 pt-6 mt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Поделиться</h4>
                                <div class="flex space-x-3">
                                    <a href="https://vk.com/share.php?url={{ urlencode(request()->url()) }}&title={{ urlencode($event['name']) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-700 text-sm">
                                        ВКонтакте
                                    </a>
                                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($event['name']) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-700 text-sm">
                                        Telegram
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Other Events -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Другие мероприятия</h2>
                
                <div class="text-center">
                    <a href="{{ route('events') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Все мероприятия
                    </a>
                </div>
            </div>
        </section>
    </div>

    <!-- JavaScript for Lightbox -->
    <script>
        const images = @json($event['images']);
        let currentImageIndex = 0;

        function openLightbox(index) {
            currentImageIndex = index;
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');
            const lightboxCaption = document.getElementById('lightbox-caption');
            
            lightboxImage.src = '{{ asset('') }}' + images[index].path;
            lightboxImage.alt = images[index].caption;
            lightboxCaption.textContent = images[index].caption;
            
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            openLightbox(currentImageIndex);
        }

        function previousImage() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            openLightbox(currentImageIndex);
        }

        // Close lightbox on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            } else if (e.key === 'ArrowLeft') {
                previousImage();
            }
        });

        // Close lightbox on background click
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
    </script>
</x-public-layout>