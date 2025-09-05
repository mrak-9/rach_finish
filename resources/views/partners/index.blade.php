<x-public-layout>
    <x-slot name="title">Партнеры - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Наши партнеры
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Мы сотрудничаем с ведущими организациями в области образования, науки и культуры
                    </p>
                </div>
            </div>
        </section>

        <!-- Partners List -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($partners->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($partners as $partner)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                @if($partner->image)
                                    <div class="h-48 bg-gray-100 flex items-center justify-center p-6">
                                        <img src="{{ Storage::url($partner->image) }}" 
                                             alt="{{ $partner->name }}" 
                                             class="max-h-full max-w-full object-contain">
                                    </div>
                                @else
                                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                        {{ $partner->name }}
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        {{ Str::limit($partner->short_description, 120) }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('partners.show', $partner) }}" 
                                           class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                                            Подробнее
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                        @if($partner->website)
                                            <a href="{{ $partner->website }}" 
                                               target="_blank" 
                                               class="text-gray-500 hover:text-gray-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $partners->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Партнеров пока нет</h3>
                        <p class="text-gray-600">Мы активно работаем над расширением партнерской сети</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Partnership CTA -->
        <section class="bg-blue-600 py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Хотите стать нашим партнером?
                </h2>
                <p class="text-xl text-blue-100 mb-8">
                    Присоединяйтесь к нашей партнерской сети и развивайте образование вместе с нами
                </p>
                <div class="bg-white rounded-lg p-8 text-left">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Контакты для партнеров</h3>
                            <p class="text-gray-600">Email: partners@rach.ru</p>
                            <p class="text-gray-600">Телефон: +7 (495) 123-45-67 доб. 103</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Направления сотрудничества</h3>
                            <ul class="text-gray-600 space-y-1">
                                <li>• Образовательные проекты</li>
                                <li>• Научные исследования</li>
                                <li>• Издательская деятельность</li>
                                <li>• Международные программы</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>