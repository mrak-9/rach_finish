<x-public-layout>
    <x-slot name="title">Наши проекты - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Наши проекты
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Инновационные проекты в области образования и развития навыков чтения
                    </p>
                </div>
            </div>
        </section>

        <!-- Projects List -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($projects->count() > 0)
                    <div class="space-y-8">
                        @foreach($projects as $project)
                            <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="p-8">
                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                                                {{ $project->name }}
                                            </h3>
                                            <p class="text-gray-600 mb-4 text-lg">
                                                {{ $project->short_description }}
                                            </p>
                                            @if($project->testing_info)
                                                <div class="mb-4">
                                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Апробация:</h4>
                                                    <p class="text-gray-600">{{ $project->testing_info }}</p>
                                                </div>
                                            @endif
                                            <a href="{{ route('projects.show', $project) }}" 
                                               class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                                                Подробнее о проекте
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="mt-4 lg:mt-0 lg:ml-8">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                                <span class="text-sm text-gray-600">Активный проект</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $projects->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Проектов пока нет</h3>
                        <p class="text-gray-600">Мы активно работаем над новыми образовательными проектами</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Project Categories -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Направления проектов</h2>
                    <p class="text-xl text-gray-600">
                        Наши проекты охватывают различные аспекты образования и развития навыков чтения
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Category 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Методики обучения</h3>
                        <p class="text-gray-600">Разработка новых методик и подходов к обучению чтению</p>
                    </div>

                    <!-- Category 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Цифровые технологии</h3>
                        <p class="text-gray-600">Интеграция современных технологий в образовательный процесс</p>
                    </div>

                    <!-- Category 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Инклюзивное образование</h3>
                        <p class="text-gray-600">Проекты для детей с особыми образовательными потребностями</p>
                    </div>

                    <!-- Category 4 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Международные проекты</h3>
                        <p class="text-gray-600">Сотрудничество с зарубежными образовательными организациями</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-blue-600 py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Хотите участвовать в наших проектах?
                </h2>
                <p class="text-xl text-blue-100 mb-8">
                    Присоединяйтесь к нашим исследованиям и образовательным инициативам
                </p>
                <div class="bg-white rounded-lg p-8 text-left">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Для исследователей</h3>
                            <p class="text-gray-600 mb-2">Email: research@rach.ru</p>
                            <p class="text-gray-600">Телефон: +7 (495) 123-45-67 доб. 104</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Для образовательных организаций</h3>
                            <p class="text-gray-600 mb-2">Email: projects@rach.ru</p>
                            <p class="text-gray-600">Телефон: +7 (495) 123-45-67 доб. 105</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>