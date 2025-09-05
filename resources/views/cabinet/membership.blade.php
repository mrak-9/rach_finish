<x-public-layout>
    <x-slot name="title">Членский взнос - Личный кабинет - Русская ассоциация чтения</x-slot>

    <div class="bg-white min-h-screen">
        <!-- Header -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Личный кабинет</h1>
                        <p class="text-gray-600 mt-1">Управление членством в РАЧ</p>
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
                       class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Мои сертификаты
                    </a>
                    <a href="{{ route('cabinet.membership') }}" 
                       class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                        Членский взнос
                    </a>
                </nav>
            </div>
        </section>

        <!-- Content -->
        <section class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Current Membership Status -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Текущий статус членства</h2>
                            
                            @if($currentMembership)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <h3 class="text-lg font-medium text-green-800">Активное членство</h3>
                                            <div class="mt-2 space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-green-700">Тип членства:</span>
                                                    <span class="text-sm font-medium text-green-800">
                                                        {{ $currentMembership->membership_type === 'individual' ? 'Индивидуальное' : 'Организация' }}
                                                    </span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-green-700">Период действия:</span>
                                                    <span class="text-sm font-medium text-green-800">
                                                        {{ $currentMembership->start_date->format('d.m.Y') }} - {{ $currentMembership->end_date->format('d.m.Y') }}
                                                    </span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-green-700">Дней до окончания:</span>
                                                    <span class="text-sm font-medium text-green-800">
                                                        {{ $currentMembership->end_date->diffInDays(now()) }}
                                                    </span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-sm text-green-700">Сумма оплаты:</span>
                                                    <span class="text-sm font-medium text-green-800">{{ number_format($currentMembership->amount, 0, ',', ' ') }} ₽</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($currentMembership->end_date->diffInDays(now()) <= 14)
                                    <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <div class="flex">
                                            <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <div>
                                                <h4 class="text-sm font-medium text-yellow-800">Скоро истекает срок членства</h4>
                                                <p class="text-sm text-yellow-700 mt-1">
                                                    Ваше членство истекает через {{ $currentMembership->end_date->diffInDays(now()) }} дней. 
                                                    Продлите членство, чтобы не потерять доступ к материалам.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg font-medium text-red-800">Членство не активно</h3>
                                            <p class="text-sm text-red-700 mt-1">
                                                У вас нет активного членства в РАЧ. Оплатите членский взнос для получения доступа ко всем возможностям.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Membership History -->
                        @if($memberships->count() > 0)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-6">История платежей</h2>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Период</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата оплаты</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($memberships as $membership)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $membership->start_date->format('d.m.Y') }} - {{ $membership->end_date->format('d.m.Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $membership->membership_type === 'individual' ? 'Индивидуальное' : 'Организация' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ number_format($membership->amount, 0, ',', ' ') }} ₽
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if($membership->status === 'paid')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                Оплачено
                                                            </span>
                                                        @elseif($membership->status === 'pending')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                Ожидает оплаты
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                Отменено
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $membership->payment_date ? $membership->payment_date->format('d.m.Y H:i') : '—' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Quick Actions -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Быстрые действия</h3>
                            
                            <div class="space-y-3">
                                @if(!$currentMembership || $currentMembership->end_date->diffInDays(now()) <= 14)
                                    <a href="{{ route('membership') }}" 
                                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        {{ $currentMembership ? 'Продлить членство' : 'Оплатить членство' }}
                                    </a>
                                @endif
                                
                                <a href="{{ route('publications') }}" 
                                   class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Посмотреть публикации
                                </a>
                                
                                <a href="{{ route('conferences') }}" 
                                   class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Конференции
                                </a>
                            </div>
                        </div>

                        <!-- Membership Benefits -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Преимущества членства</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Доступ к публикациям</h4>
                                        <p class="text-sm text-gray-600">Скачивайте научные статьи и методические материалы</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Участие в конференциях</h4>
                                        <p class="text-sm text-gray-600">Регистрируйтесь на закрытые мероприятия</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Сертификаты</h4>
                                        <p class="text-sm text-gray-600">Получайте сертификаты о прохождении мероприятий</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Профессиональная сеть</h4>
                                        <p class="text-sm text-gray-600">Общайтесь с коллегами и экспертами</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>