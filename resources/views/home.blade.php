<x-public-layout>
    <x-slot name="title">Главная - Русская ассоциация чтения</x-slot>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Русская ассоциация чтения
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Объединяем специалистов в области чтения и грамотности для развития образования и культуры в России. 
                    Проводим конференции, семинары и исследования, направленные на повышение качества обучения чтению.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('membership') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Вступить в РАЧ
                    </a>
                    <a href="{{ route('about') }}" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-3 rounded-lg font-semibold border border-gray-300 transition-colors inline-flex items-center justify-center">
                        Узнать больше
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Directions Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Наши направления</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Мероприятия</h3>
                    <p class="text-gray-600 mb-4">Конференции, семинары и вебинары для специалистов</p>
                    <a href="{{ route('events') }}" class="text-blue-600 hover:text-blue-700 font-medium">Смотреть события</a>
                </div>
                <div class="text-center p-6 rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Издания</h3>
                    <p class="text-gray-600 mb-4">Научные публикации и методические материалы</p>
                    <a href="{{ route('publications') }}" class="text-blue-600 hover:text-blue-700 font-medium">Наши издания</a>
                </div>
                <div class="text-center p-6 rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Сообщество</h3>
                    <p class="text-gray-600 mb-4">Объединение экспертов и практиков образования</p>
                    <a href="{{ route('membership') }}" class="text-blue-600 hover:text-blue-700 font-medium">Присоединиться</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Последние новости</h2>
                <a href="{{ route('news') }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                    Все новости
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestNews as $news)
                <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">{{ $news->published_at->format('d.m.Y') }}</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $news->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $news->excerpt }}</p>
                        <a href="{{ route('news.show', $news) }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                            Читать далее
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>
                @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">Новости пока не добавлены</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Ближайшие мероприятия</h2>
                <a href="{{ route('events') }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                    Все мероприятия
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($upcomingConferences as $conference)
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="text-sm text-gray-500 mb-2">{{ $conference->start_date->format('d.m.Y') }}</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $conference->title }}</h3>
                        <div class="text-sm text-gray-600 mb-4">
                            <p>Формат: {{ $conference->format }}</p>
                            <p>Место: {{ $conference->location }}</p>
                        </div>
                        <a href="{{ route('conferences.show', $conference) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Зарегистрироваться
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">Мероприятия пока не запланированы</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</x-public-layout>