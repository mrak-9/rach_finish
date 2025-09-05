<x-public-layout>
    <x-slot name="title">Мои мероприятия - Личный кабинет - Русская ассоциация чтения</x-slot>

    <div class="bg-white min-h-screen">
        <!-- Header -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Личный кабинет</h1>
                        <p class="text-gray-600 mt-1">Мои мероприятия и конференции</p>
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
                       class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                        Мои мероприятия
                    </a>
                    <a href="{{ route('cabinet.certificates') }}" 
                       class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Мои сертификаты
                    </a>
                    <a href="{{ route('cabinet.membership') }}" 
                       class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Членский взнос
                    </a>
                </nav>
            </div>
        </section>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Content -->
        <section class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($participations->count() > 0)
                    <div class="space-y-6">
                        @foreach($participations as $participation)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                                <a href="{{ route('conferences.show', $participation->conference) }}" 
                                                   class="hover:text-blue-600">
                                                    {{ $participation->conference->title }}
                                                </a>
                                            </h3>
                                            
                                            <div class="space-y-2 mb-4">
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 0h6m-6 0a1 1 0 00-1 1v10a1 1 0 001 1h6a1 1 0 001-1V8a1 1 0 00-1-1"/>
                                                    </svg>
                                                    Дата: {{ \Carbon\Carbon::parse($participation->event_date)->format('d.m.Y') }}
                                                </div>
                                                
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                    Формат: {{ str_replace(',', ', ', $participation->participation_format) }}
                                                </div>
                                                
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                                    </svg>
                                                    Членство: {{ $participation->has_paid_membership ? 'Оплачено' : 'Не оплачено' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="ml-6">
                                            @if($participation->is_approved)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Подтверждено
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Ожидает подтверждения
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Theses Section -->
                                    @if($participation->theses->count() > 0)
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <h4 class="text-lg font-medium text-gray-900 mb-4">Загруженные тезисы</h4>
                                            <div class="space-y-3">
                                                @foreach($participation->theses as $thesis)
                                                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                                                        <div class="flex-1">
                                                            <h5 class="font-medium text-gray-900">{{ $thesis->title }}</h5>
                                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($thesis->description, 100) }}</p>
                                                        </div>
                                                        <div class="ml-4 flex items-center space-x-3">
                                                            @if($thesis->is_approved)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                    Принят
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                    На рассмотрении
                                                                </span>
                                                            @endif
                                                            <a href="{{ Storage::url($thesis->file_path) }}" 
                                                               target="_blank"
                                                               class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                                                Скачать
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Upload Thesis Section -->
                                    @if($participation->conference->conference_date >= now())
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <div class="flex items-center justify-between mb-4">
                                                <h4 class="text-lg font-medium text-gray-900">Загрузить тезис</h4>
                                                <button onclick="toggleThesisForm({{ $participation->id }})" 
                                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                    Добавить тезис
                                                </button>
                                            </div>

                                            <div id="thesis-form-{{ $participation->id }}" class="hidden">
                                                <form action="{{ route('cabinet.thesis.upload', $participation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                                    @csrf
                                                    
                                                    <div>
                                                        <label for="title-{{ $participation->id }}" class="block text-sm font-medium text-gray-700 mb-1">Заголовок работы *</label>
                                                        <input type="text" id="title-{{ $participation->id }}" name="title" required
                                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label for="description-{{ $participation->id }}" class="block text-sm font-medium text-gray-700 mb-1">Описание работы *</label>
                                                        <textarea id="description-{{ $participation->id }}" name="description" rows="3" required
                                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                                    </div>

                                                    <div>
                                                        <label for="file-{{ $participation->id }}" class="block text-sm font-medium text-gray-700 mb-1">Файл работы *</label>
                                                        <input type="file" id="file-{{ $participation->id }}" name="file" accept=".pdf,.doc,.docx" required
                                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                        <p class="text-sm text-gray-500 mt-1">Поддерживаемые форматы: PDF, DOC, DOCX. Максимальный размер: 10 МБ</p>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <input type="checkbox" id="publish_consent-{{ $participation->id }}" name="publish_consent" required
                                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                        <label for="publish_consent-{{ $participation->id }}" class="ml-2 block text-sm text-gray-700">
                                                            Согласие на публикацию работы *
                                                        </label>
                                                    </div>

                                                    <div class="flex space-x-3">
                                                        <button type="submit" 
                                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                            Загрузить тезис
                                                        </button>
                                                        <button type="button" onclick="toggleThesisForm({{ $participation->id }})"
                                                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                            Отмена
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Certificate Link -->
                                    @if($participation->is_approved && $participation->conference->conference_date < now())
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-lg font-medium text-gray-900">Сертификат участия</h4>
                                                    <p class="text-sm text-gray-600">Сертификат доступен для скачивания</p>
                                                </div>
                                                <a href="{{ route('cabinet.certificates') }}" 
                                                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                                    </svg>
                                                    Получить сертификат
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Вы пока не участвовали в мероприятиях</h3>
                        <p class="text-gray-600 mb-6">Зарегистрируйтесь на конференции и семинары РАЧ</p>
                        <a href="{{ route('conferences') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            Посмотреть конференции
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <script>
        function toggleThesisForm(participationId) {
            const form = document.getElementById('thesis-form-' + participationId);
            form.classList.toggle('hidden');
        }
    </script>
</x-public-layout>