<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Русская ассоциация чтения' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <!-- Top bar -->
        <div class="bg-slate-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-2">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-lg font-bold">РАЧ</h1>
                                <p class="text-xs text-gray-300">Русская ассоциация чтения</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="text-sm">
                            <p>+7 (495) 123-45-67</p>
                            <p>info@rach.ru</p>
                        </div>
                        @auth
                            <div class="relative group">
                                <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>{{ Str::limit(Auth::user()->name, 15) }}</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('cabinet.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Мой профиль</a>
                                    <a href="{{ route('cabinet.events') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Мои мероприятия</a>
                                    <a href="{{ route('cabinet.certificates') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Мои сертификаты</a>
                                    <a href="{{ route('cabinet.membership') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Членский взнос</a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Выйти</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Войти в ЛК</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="bg-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex space-x-8">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Главная
                            </a>
                            <div class="relative group">
                                <button class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors h-16">
                                    О нас
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div class="absolute left-0 mt-0 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('about') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">О нас</a>
                                        <a href="{{ route('media') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">СМИ о нас</a>
                                        <a href="{{ route('cooperation') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Международное сотрудничество</a>
                                        <a href="{{ route('offer') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Публичная оферта</a>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('branches') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Отделения РАЧ
                            </a>
                            <a href="{{ route('news') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Новости
                            </a>
                            <a href="{{ route('events') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Мероприятия
                            </a>
                            <a href="{{ route('conferences') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Конференции и семинары
                            </a>
                            <a href="{{ route('publications') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Наши издания
                            </a>
                            <a href="{{ route('projects') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Наши проекты
                            </a>
                            <a href="{{ route('partners') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Партнеры
                            </a>
                            <a href="{{ route('membership') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-300 transition-colors">
                                Членство в РАЧ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">РАЧ</h3>
                            <p class="text-sm text-gray-300">Русская ассоциация чтения</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-300 space-y-1">
                        <p>+7 (495) 123-45-67</p>
                        <p>info@rach.ru</p>
                        <p>Москва, Россия</p>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Информация</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors">О нас</a></li>
                        <li><a href="{{ route('offer') }}" class="text-gray-300 hover:text-white transition-colors">Публичная оферта</a></li>
                        <li><a href="{{ route('membership') }}" class="text-gray-300 hover:text-white transition-colors">Членство в РАЧ</a></li>
                        <li><a href="{{ route('partners') }}" class="text-gray-300 hover:text-white transition-colors">Партнеры</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Разделы</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('news') }}" class="text-gray-300 hover:text-white transition-colors">Новости</a></li>
                        <li><a href="{{ route('events') }}" class="text-gray-300 hover:text-white transition-colors">Мероприятия</a></li>
                        <li><a href="{{ route('conferences') }}" class="text-gray-300 hover:text-white transition-colors">Конференции</a></li>
                        <li><a href="{{ route('publications') }}" class="text-gray-300 hover:text-white transition-colors">Издания</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-300">
                <p>&copy; 2024 Русская ассоциация чтения. Все права защищены.</p>
            </div>
        </div>
    </footer>
</body>
</html>