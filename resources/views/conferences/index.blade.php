<x-public-layout>
    <x-slot name="title">Конференции и семинары - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Конференции и семинары
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Научно-практические мероприятия для специалистов в области образования и чтения
                    </p>
                </div>
            </div>
        </section>

        <!-- Current Conference -->
        @if($currentConference)
            <section class="py-16 bg-blue-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Текущее мероприятие
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $currentConference->title }}</h2>
                        <p class="text-lg text-gray-600 mb-6">{{ $currentConference->conference_start_date->format('d.m.Y') }}</p>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-8">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    @if($currentConference->announcement)
                                        <div class="prose prose-lg max-w-none mb-6">
                                            {!! Str::limit($currentConference->announcement, 300) !!}
                                        </div>
                                    @endif
                                    
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 0h6m-6 0a1 1 0 00-1 1v10a1 1 0 001 1h6a1 1 0 001-1V8a1 1 0 00-1-1"/>
                                            </svg>
                                            <span class="text-gray-600">{{ $currentConference->format }}</span>
                                        </div>
                                        
                                        @if($currentConference->location)
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span class="text-gray-600">{{ $currentConference->location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Регистрация</h3>
                                    
                                    @auth
                                        @php
                                            $userParticipation = $currentConference->participants()->where('user_id', Auth::id())->first();
                                        @endphp
                                        
                                        @if($userParticipation)
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                                <div class="flex">
                                                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <div>
                                                        <h4 class="text-sm font-medium text-green-800">Вы зарегистрированы</h4>
                                                        <p class="text-sm text-green-700 mt-1">
                                                            Статус: {{ $userParticipation->is_approved ? 'Подтверждено' : 'Ожидает подтверждения' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($currentConference->registration_start_date <= now())
                                            <a href="{{ route('conferences.show', $currentConference) }}" 
                                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                                                Зарегистрироваться
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        @else
                                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                                <p class="text-sm text-yellow-800">
                                                    Регистрация откроется {{ $currentConference->registration_start_date->format('d.m.Y') }}
                                                </p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bg-gray-100 border border-gray-200 rounded-lg p-4">
                                            <p class="text-sm text-gray-600 mb-3">
                                                Для регистрации необходимо войти в систему
                                            </p>
                                            <a href="{{ route('login') }}" 
                                               class="text-blue-600 hover:text-blue-700 font-medium">
                                                Войти в систему →
                                            </a>
                                        </div>
                                    @endauth
                                    
                                    <a href="{{ route('conferences.show', $currentConference) }}" 
                                       class="mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                                        Подробнее о конференции
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Past Conferences -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Прошедшие конференции</h2>
                
                @if($pastConferences->count() > 0)
                    @foreach($pastConferences as $year => $conferences)
                        <div class="mb-12">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-6 border-b border-gray-200 pb-2">
                                {{ $year }} год
                            </h3>
                            <div class="space-y-6">
                                @foreach($conferences as $conference)
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                        <div class="p-6">
                                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center mb-2">
                                                        <time class="text-sm text-blue-600 font-medium">
                                                            {{ $conference->conference_start_date->format('d.m.Y') }}
                                                        </time>
                                                        <span class="mx-2 text-gray-300">•</span>
                                                        <span class="text-sm text-gray-600">{{ $conference->format }}</span>
                                                    </div>
                                                    
                                                    <h4 class="text-xl font-semibold text-gray-900 mb-3">
                                                        {{ $conference->title }}
                                                    </h4>
                                                    
                                                    @if($conference->announcement)
                                                        <p class="text-gray-600 mb-4">
                                                            {{ Str::limit(strip_tags($conference->announcement), 150) }}
                                                        </p>
                                                    @endif

                                                    <div class="flex items-center justify-between">
                                                        <a href="{{ route('conferences.show', $conference) }}" 
                                                           class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                                                            Подробнее
                                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                            </svg>
                                                        </a>

                                                        <div class="text-sm text-gray-500">
                                                            {{ $conference->participants_count ?? 0 }} участников
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Конференций пока нет</h3>
                        <p class="text-gray-600">Информация о прошедших конференциях будет добавлена позже</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Conference Features -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Возможности участия</h2>
                    <p class="text-xl text-gray-600">
                        Наши конференции предоставляют различные форматы участия и возможности
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Онлайн участие</h3>
                        <p class="text-gray-600">Участвуйте в конференциях удаленно из любой точки мира</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Подача тезисов</h3>
                        <p class="text-gray-600">Представьте свои исследования и получите обратную связь</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Сертификаты</h3>
                        <p class="text-gray-600">Получите сертификат о прохождении конференции</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Нетворкинг</h3>
                        <p class="text-gray-600">Знакомьтесь с коллегами и обменивайтесь опытом</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>