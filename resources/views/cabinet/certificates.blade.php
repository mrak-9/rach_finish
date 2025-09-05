<x-public-layout>
    <x-slot name="title">Мои сертификаты - Личный кабинет - Русская ассоциация чтения</x-slot>

    <div class="bg-white min-h-screen">
        <!-- Header -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Личный кабинет</h1>
                        <p class="text-gray-600 mt-1">Мои сертификаты участия</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Добро пожаловать,</p>
                        <p class="text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navigation -->
        <section class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex space-x-8">
                    <a href="{{ route('cabinet.profile') }}" 
                       class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Мой профиль
                    </a>
                    <a href="{{ route('cabinet.events') }}" 
                       class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Мои мероприятия
                    </a>
                    <a href="{{ route('cabinet.certificates') }}" 
                       class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                        Мои сертификаты
                    </a>
                    <a href="{{ route('cabinet.membership') }}" 
                       class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Членский взнос
                    </a>
                </nav>
            </div>
        </section>

        <!-- Content -->
        <section class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($certificates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($certificates as $certificate)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                <!-- Certificate Preview -->
                                <div class="bg-gradient-to-br from-blue-50 to-purple-50 p-8 text-center">
                                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Сертификат участия</h3>
                                    <p class="text-sm text-gray-600">{{ $certificate->conference->title }}</p>
                                </div>

                                <!-- Certificate Details -->
                                <div class="p-6">
                                    <div class="space-y-3 mb-6">
                                        <div class="flex items-center text-sm">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 0h6m-6 0a1 1 0 00-1 1v10a1 1 0 001 1h6a1 1 0 001-1V8a1 1 0 00-1-1"/>
                                            </svg>
                                            <span class="text-gray-600">Дата мероприятия:</span>
                                            <span class="ml-2 font-medium text-gray-900">{{ $certificate->conference->conference_date->format('d.m.Y') }}</span>
                                        </div>

                                        <div class="flex items-center text-sm">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="text-gray-600">Место:</span>
                                            <span class="ml-2 font-medium text-gray-900">{{ $certificate->conference->location ?: 'Онлайн' }}</span>
                                        </div>

                                        <div class="flex items-center text-sm">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-gray-600">Формат:</span>
                                            <span class="ml-2 font-medium text-gray-900">{{ str_replace(',', ', ', $certificate->participation_format) }}</span>
                                        </div>

                                        <div class="flex items-center text-sm">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span class="text-gray-600">Участник:</span>
                                            <span class="ml-2 font-medium text-gray-900">{{ Auth::user()->name }}</span>
                                        </div>
                                    </div>

                                    <!-- Download Button -->
                                    <button onclick="generateCertificate({{ $certificate->id }})" 
                                            class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-4-8V4"/>
                                        </svg>
                                        Скачать сертификат
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Statistics -->
                    <div class="mt-12 bg-gray-50 rounded-lg p-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">Статистика участия</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $certificates->count() }}</div>
                                <div class="text-sm text-gray-600">Полученных сертификатов</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 mb-2">{{ $certificates->where('conference.format', 'online')->count() }}</div>
                                <div class="text-sm text-gray-600">Онлайн мероприятий</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $certificates->where('conference.format', 'offline')->count() }}</div>
                                <div class="text-sm text-gray-600">Очных мероприятий</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">У вас пока нет сертификатов</h3>
                        <p class="text-gray-600 mb-6">Сертификаты появятся после участия в подтвержденных мероприятиях</p>
                        <div class="space-y-4">
                            <a href="{{ route('conferences') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-block">
                                Посмотреть конференции
                            </a>
                            <div class="text-sm text-gray-500">
                                <p>Для получения сертификата необходимо:</p>
                                <ul class="mt-2 space-y-1">
                                    <li>• Зарегистрироваться на мероприятие</li>
                                    <li>• Получить подтверждение участия от администратора</li>
                                    <li>• Дождаться окончания мероприятия</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <script>
        function generateCertificate(certificateId) {
            // В реальном проекте здесь была бы генерация PDF сертификата
            // Для демонстрации показываем уведомление
            alert('Функция генерации сертификата будет реализована в следующей версии.\n\nСертификат будет содержать:\n- ФИО участника\n- Название мероприятия\n- Дату проведения\n- Подпись организаторов');
        }
    </script>
</x-public-layout>