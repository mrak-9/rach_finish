<x-public-layout>
    <x-slot name="title">{{ $news->title }} - Русская ассоциация чтения</x-slot>

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
                                <a href="{{ route('news') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Новости
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">
                                    {{ Str::limit($news->title, 50) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Article Content -->
        <article class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Article Header -->
                <header class="mb-8">
                    <div class="text-sm text-gray-500 mb-4">
                        {{ $news->published_at->format('d.m.Y') }}
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        {{ $news->title }}
                    </h1>
                    @if($news->excerpt)
                        <p class="text-xl text-gray-600 leading-relaxed">
                            {{ $news->excerpt }}
                        </p>
                    @endif
                </header>

                <!-- Article Body -->
                <div class="prose prose-lg max-w-none">
                    {!! $news->content !!}
                </div>

                <!-- Article Footer -->
                <footer class="mt-12 pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Опубликовано {{ $news->published_at->format('d.m.Y в H:i') }}
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">Поделиться:</span>
                            <a href="https://vk.com/share.php?url={{ urlencode(request()->url()) }}&title={{ urlencode($news->title) }}" 
                               target="_blank" 
                               class="text-blue-600 hover:text-blue-700">
                                ВКонтакте
                            </a>
                            <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" 
                               target="_blank" 
                               class="text-blue-600 hover:text-blue-700">
                                Telegram
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </article>

        <!-- Related News -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Другие новости</h2>
                
                @php
                    $relatedNews = App\Models\News::where('is_published', true)
                        ->where('id', '!=', $news->id)
                        ->orderBy('published_at', 'desc')
                        ->limit(3)
                        ->get();
                @endphp

                @if($relatedNews->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedNews as $relatedItem)
                            <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="p-6">
                                    <div class="text-sm text-gray-500 mb-2">
                                        {{ $relatedItem->published_at->format('d.m.Y') }}
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                        <a href="{{ route('news.show', $relatedItem) }}" class="hover:text-blue-600">
                                            {{ $relatedItem->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        {{ Str::limit($relatedItem->excerpt, 100) }}
                                    </p>
                                    <a href="{{ route('news.show', $relatedItem) }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                                        Читать далее
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                <div class="text-center mt-8">
                    <a href="{{ route('news') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Все новости
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>