<x-public-layout>
    <x-slot name="title">Отделения РАЧ - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Отделения РАЧ
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Региональные отделения Русской ассоциации чтения по всей России
                    </p>
                </div>
            </div>
        </section>

        <!-- Branches by Region -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($branches->count() > 0)
                    @foreach($branches as $region => $regionBranches)
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-2">
                                {{ $region }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($regionBranches as $branch)
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                        <div class="p-6">
                                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                                {{ $branch->name }}
                                            </h3>
                                            
                                            @if($branch->short_description)
                                                <p class="text-gray-600 mb-4">
                                                    {{ Str::limit($branch->short_description, 120) }}
                                                </p>
                                            @endif

                                            <!-- Contact Info -->
                                            <div class="space-y-2 mb-4">
                                                @if($branch->address)
                                                    <div class="flex items-start">
                                                        <svg class="w-4 h-4 text-gray-400 mt-1 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        <span class="text-sm text-gray-600">{{ $branch->address }}</span>
                                                    </div>
                                                @endif
                                                
                                                @if($branch->phone)
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                        </svg>
                                                        <span class="text-sm text-gray-600">{{ $branch->phone }}</span>
                                                    </div>
                                                @endif
                                                
                                                @if($branch->email)
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span class="text-sm text-gray-600">{{ $branch->email }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <a href="{{ route('branches.show', $branch) }}" 
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
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Отделений пока нет</h3>
                        <p class="text-gray-600">Мы активно работаем над открытием региональных отделений</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Regional Coverage -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">География присутствия</h2>
                    <p class="text-xl text-gray-600">
                        Наши отделения работают в ключевых регионах России
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Region 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Центральный ФО</h3>
                        <p class="text-gray-600">Москва, Московская область, Тула, Рязань</p>
                    </div>

                    <!-- Region 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Северо-Западный ФО</h3>
                        <p class="text-gray-600">Санкт-Петербург, Новгород, Псков</p>
                    </div>

                    <!-- Region 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Уральский ФО</h3>
                        <p class="text-gray-600">Екатеринбург, Челябинск, Пермь</p>
                    </div>

                    <!-- Region 4 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Сибирский ФО</h3>
                        <p class="text-gray-600">Новосибирск, Омск, Красноярск</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-blue-600 py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Хотите открыть отделение в вашем регионе?
                </h2>
                <p class="text-xl text-blue-100 mb-8">
                    Свяжитесь с нами для обсуждения возможности создания регионального отделения РАЧ
                </p>
                <div class="bg-white rounded-lg p-8 text-left">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Координатор по регионам</h3>
                            <p class="text-gray-600">Email: regions@rach.ru</p>
                            <p class="text-gray-600">Телефон: +7 (495) 123-45-67 доб. 106</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Требования</h3>
                            <ul class="text-gray-600 space-y-1">
                                <li>• Минимум 10 активных членов</li>
                                <li>• Координатор отделения</li>
                                <li>• План работы на год</li>
                                <li>• Помещение для мероприятий</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>