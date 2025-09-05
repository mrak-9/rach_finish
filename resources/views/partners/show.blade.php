<x-public-layout>
    <x-slot name="title">{{ $partner->name }} - Партнеры - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Breadcrumbs -->
        <section class="bg-gray-50 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                    <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    <span class="sr-only">Главная</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ route('partners') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Партнеры
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">
                                    {{ Str::limit($partner->name, 30) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Partner Details -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Partner Logo and Info -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg border border-gray-200 p-8 sticky top-8">
                            @if($partner->image)
                                <div class="mb-6">
                                    <img src="{{ Storage::url($partner->image) }}" 
                                         alt="{{ $partner->name }}" 
                                         class="w-full h-48 object-contain">
                                </div>
                            @else
                                <div class="mb-6 h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                </div>
                            @endif
                            
                            <h1 class="text-2xl font-bold text-gray-900 mb-4">
                                {{ $partner->name }}
                            </h1>
                            
                            @if($partner->short_description)
                                <p class="text-gray-600 mb-6">
                                    {{ $partner->short_description }}
                                </p>
                            @endif

                            @if($partner->website)
                                <a href="{{ $partner->website }}" 
                                   target="_blank" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Перейти на сайт
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Partner Description -->
                    <div class="lg:col-span-2">
                        <div class="prose prose-lg max-w-none">
                            @if($partner->description)
                                {!! $partner->description !!}
                            @else
                                <p class="text-gray-600">
                                    Подробная информация о партнере будет добавлена позже.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Other Partners -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Другие партнеры</h2>
                
                @php
                    $otherPartners = App\Models\Partner::where('id', '!=', $partner->id)
                        ->orderBy('name')
                        ->limit(3)
                        ->get();
                @endphp

                @if($otherPartners->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($otherPartners as $otherPartner)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                @if($otherPartner->image)
                                    <div class="h-32 bg-gray-100 flex items-center justify-center p-4">
                                        <img src="{{ Storage::url($otherPartner->image) }}" 
                                             alt="{{ $otherPartner->name }}" 
                                             class="max-h-full max-w-full object-contain">
                                    </div>
                                @else
                                    <div class="h-32 bg-gray-100 flex items-center justify-center">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('partners.show', $otherPartner) }}" class="hover:text-blue-600">
                                            {{ $otherPartner->name }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        {{ Str::limit($otherPartner->short_description, 80) }}
                                    </p>
                                    <a href="{{ route('partners.show', $otherPartner) }}" 
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
                @endif

                <div class="text-center mt-8">
                    <a href="{{ route('partners') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Все партнеры
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>