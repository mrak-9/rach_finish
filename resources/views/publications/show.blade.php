<x-public-layout>
    <x-slot name="title">{{ $publication->title }} - Наши издания - Русская ассоциация чтения</x-slot>

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
                                <a href="{{ route('publications') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Наши издания
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">
                                    {{ Str::limit($publication->title, 30) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Publication Details -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Publication Cover and Info -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg border border-gray-200 p-8 sticky top-8">
                            @if($publication->cover_image)
                                <div class="mb-6">
                                    <img src="{{ Storage::url($publication->cover_image) }}" 
                                         alt="{{ $publication->title }}" 
                                         class="w-full rounded-lg shadow-sm">
                                </div>
                            @else
                                <div class="mb-6 h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm">Обложка</p>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-2">Дата публикации</h4>
                                <p class="text-gray-600">{{ $publication->published_at->format('d.m.Y') }}</p>
                            </div>

                            @if($publication->short_description)
                                <div class="mb-6">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Краткое описание</h4>
                                    <p class="text-gray-600 text-sm">{{ $publication->short_description }}</p>
                                </div>
                            @endif

                            <!-- Download Section -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Скачать материалы</h4>
                                
                                @auth
                                    @if(Auth::user()->hasActiveMembership())
                                        @if($publication->files && count($publication->files) > 0)
                                            <div class="space-y-2">
                                                @foreach($publication->files as $file)
                                                    <a href="{{ route('publications.download', [$publication, basename($file)]) }}" 
                                                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center justify-center text-sm">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-4-8V4"/>
                                                        </svg>
                                                        {{ basename($file) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-gray-500 text-sm">Файлы для скачивания пока не добавлены</p>
                                        @endif
                                    @else
                                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                            <div class="flex">
                                                <svg class="w-5 h-5 text-red-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                </svg>
                                                <div>
                                                    <h5 class="text-sm font-medium text-red-800">Требуется членство</h5>
                                                    <p class="text-sm text-red-700 mt-1">
                                                        Для скачивания публикаций необходимо оплатить членский взнос.
                                                    </p>
                                                    <a href="{{ route('membership') }}" 
                                                       class="text-sm font-medium text-red-800 hover:text-red-900 underline mt-2 inline-block">
                                                        Оплатить членство →
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <div class="flex">
                                            <svg class="w-5 h-5 text-yellow-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <div>
                                                <h5 class="text-sm font-medium text-yellow-800">Требуется авторизация</h5>
                                                <p class="text-sm text-yellow-700 mt-1">
                                                    Для скачивания публикаций необходимо войти в систему.
                                                </p>
                                                <a href="{{ route('login') }}" 
                                                   class="text-sm font-medium text-yellow-800 hover:text-yellow-900 underline mt-2 inline-block">
                                                    Войти в систему →
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endauth
                            </div>

                            <div class="border-t border-gray-200 pt-6 mt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Поделиться</h4>
                                <div class="flex space-x-3">
                                    <a href="https://vk.com/share.php?url={{ urlencode(request()->url()) }}&title={{ urlencode($publication->title) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-700 text-sm">
                                        ВКонтакте
                                    </a>
                                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($publication->title) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-700 text-sm">
                                        Telegram
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Publication Description -->
                    <div class="lg:col-span-2">
                        <div class="mb-6">
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                                {{ $publication->title }}
                            </h1>
                            <div class="text-sm text-blue-600 font-medium">
                                Опубликовано {{ $publication->published_at->format('d.m.Y') }}
                            </div>
                        </div>

                        <div class="prose prose-lg max-w-none">
                            @if($publication->description)
                                {!! $publication->description !!}
                            @else
                                <p class="text-gray-600">
                                    Подробное описание публикации будет добавлено позже.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Publications -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Другие публикации</h2>
                
                @php
                    $relatedPublications = App\Models\Publication::where('id', '!=', $publication->id)
                        ->orderBy('published_at', 'desc')
                        ->limit(3)
                        ->get();
                @endphp

                @if($relatedPublications->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedPublications as $relatedPublication)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                @if($relatedPublication->cover_image)
                                    <div class="h-48 bg-gray-100 flex items-center justify-center p-4">
                                        <img src="{{ Storage::url($relatedPublication->cover_image) }}" 
                                             alt="{{ $relatedPublication->title }}" 
                                             class="max-h-full max-w-full object-contain">
                                    </div>
                                @else
                                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <div class="text-sm text-blue-600 font-medium mb-2">
                                        {{ $relatedPublication->published_at->format('d.m.Y') }}
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('publications.show', $relatedPublication) }}" class="hover:text-blue-600">
                                            {{ $relatedPublication->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        {{ Str::limit($relatedPublication->short_description, 80) }}
                                    </p>
                                    <a href="{{ route('publications.show', $relatedPublication) }}" 
                                       class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                                        Подробнее
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="text-center mt-8">
                    <a href="{{ route('publications') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Все публикации
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>