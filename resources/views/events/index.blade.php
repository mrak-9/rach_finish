<x-public-layout>
    <x-slot name="title">Мероприятия - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Мероприятия
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Фотоотчеты с конференций, семинаров и других образовательных мероприятий РАЧ
                    </p>
                </div>
            </div>
        </section>

        <!-- Events List -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($events->count() > 0)
                    <div class="space-y-8">
                        @foreach($events as $event)
                            <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="p-8">
                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                                        <!-- Event Images Slider -->
                                        <div class="flex-shrink-0 mb-6 lg:mb-0 lg:mr-8">
                                            @if($event->hasImages())
                                                <div class="w-full lg:w-80">
                                                    @php $sliderImages = $event->getSliderImages(); @endphp
                                                    @if(count($sliderImages) == 1)
                                                        <img src="{{ $sliderImages[0]['url'] }}" 
                                                             alt="{{ $sliderImages[0]['caption'] }}" 
                                                             class="w-full h-48 object-cover rounded-lg">
                                                    @else
                                                        <!-- Simple image slider -->
                                                        <div class="relative">
                                                            <div class="overflow-hidden rounded-lg">
                                                                <div class="flex transition-transform duration-300" id="slider-{{ $loop->index }}">
                                                                    @foreach($sliderImages as $image)
                                                                        <img src="{{ $image['url'] }}" 
                                                                             alt="{{ $image['caption'] }}" 
                                                                             class="w-full h-48 object-cover flex-shrink-0">
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            @if(count($sliderImages) > 1)
                                                                <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-1">
                                                                    @foreach($sliderImages as $index => $image)
                                                                        <div class="w-2 h-2 bg-white bg-opacity-50 rounded-full {{ $index === 0 ? 'bg-opacity-100' : '' }}"></div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <p class="text-sm text-gray-500 mt-2 text-center">
                                                        {{ count($event['images']) }} {{ count($event['images']) == 1 ? 'фотография' : 'фотографий' }}
                                                    </p>
                                                </div>
                                            @else
                                                <div class="w-full lg:w-80 h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <div class="text-center">
                                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <p class="text-gray-500 text-sm">Фотографии будут добавлены</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Event Content -->
                                        <div class="flex-1">
                                            <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                                                {{ $event->name }}
                                            </h3>
                                            
                                            <p class="text-gray-600 mb-4 text-lg">
                                                {{ $event->getShortDescription() }}
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <a href="{{ $event->getUrl() }}" 
                                                   class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                                                    Смотреть фотоотчет
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </a>

                                                <div class="text-sm text-gray-500">
                                                    @if($event->hasImages())
                                                        {{ count($event->images) }} фотографий
                                                    @else
                                                        Фотографии будут добавлены
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Simple Pagination -->
                    @if($pagination['total'] > $pagination['per_page'])
                        <div class="mt-12 flex justify-center">
                            <nav class="flex items-center space-x-2">
                                @if($pagination['current_page'] > 1)
                                    <a href="?page={{ $pagination['current_page'] - 1 }}" 
                                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Предыдущая
                                    </a>
                                @endif
                                
                                @php
                                    $totalPages = $pagination['last_page'];
                                @endphp
                                
                                @for($i = 1; $i <= $totalPages; $i++)
                                    <a href="?page={{ $i }}" 
                                       class="px-3 py-2 text-sm font-medium {{ $i == $pagination['current_page'] ? 'text-blue-600 bg-blue-50 border-blue-500' : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-50' }} border rounded-md">
                                        {{ $i }}
                                    </a>
                                @endfor
                                
                                @if($pagination['has_more_pages'])
                                    <a href="?page={{ $pagination['current_page'] + 1 }}" 
                                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Следующая
                                    </a>
                                @endif
                            </nav>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Мероприятий пока нет</h3>
                        <p class="text-gray-600">Фотоотчеты с мероприятий будут добавлены позже</p>
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 max-w-md mx-auto">
                            <h4 class="text-sm font-semibold text-blue-900 mb-2">Как добавить мероприятие?</h4>
                            <p class="text-sm text-blue-800">
                                Создайте папку в <code>storage/app/public/events/</code> с названием мероприятия, 
                                добавьте фотографии и файл <code>description.txt</code> с описанием.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Event Types -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Типы мероприятий</h2>
                    <p class="text-xl text-gray-600">
                        РАЧ организует различные образовательные и научные мероприятия
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Type 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Конференции</h3>
                        <p class="text-gray-600">Ежегодные научно-практические конференции</p>
                    </div>

                    <!-- Type 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Семинары</h3>
                        <p class="text-gray-600">Тематические семинары и мастер-классы</p>
                    </div>

                    <!-- Type 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Круглые столы</h3>
                        <p class="text-gray-600">Дискуссии по актуальным вопросам образования</p>
                    </div>

                    <!-- Type 4 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Международные встречи</h3>
                        <p class="text-gray-600">Сотрудничество с зарубежными коллегами</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>