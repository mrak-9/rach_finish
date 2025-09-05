<x-public-layout>
    <x-slot name="title">Новости - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Новости
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Актуальные события и новости из мира образования и чтения
                    </p>
                </div>
            </div>
        </section>

        <!-- News List -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($news->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($news as $newsItem)
                            <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="p-6">
                                    <div class="text-sm text-gray-500 mb-2">
                                        {{ $newsItem->published_at->format('d.m.Y') }}
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                        {{ $newsItem->title }}
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        {{ Str::limit($newsItem->excerpt, 150) }}
                                    </p>
                                    <a href="{{ route('news.show', $newsItem) }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                                        Читать далее
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $news->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Новостей пока нет</h3>
                        <p class="text-gray-600">Следите за обновлениями на нашем сайте</p>
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-public-layout>