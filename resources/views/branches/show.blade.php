<x-public-layout>
    <x-slot name="title">{{ $branch->name }} - Отделения РАЧ - Русская ассоциация чтения</x-slot>

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
                                <a href="{{ route('branches') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Отделения РАЧ
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">
                                    {{ Str::limit($branch->name, 30) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Branch Header -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <div class="mb-6">
                            <div class="text-sm text-blue-600 font-medium mb-2">{{ $branch->region }}</div>
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                                {{ $branch->name }}
                            </h1>
                            @if($branch->short_description)
                                <p class="text-xl text-gray-600">
                                    {{ $branch->short_description }}
                                </p>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="prose prose-lg max-w-none mb-12">
                            @if($branch->description)
                                {!! $branch->description !!}
                            @else
                                <p class="text-gray-600">
                                    Подробная информация об отделении будет добавлена позже.
                                </p>
                            @endif
                        </div>

                        <!-- Projects -->
                        @if($branch->projects && $branch->projects->count() > 0)
                            <div class="mb-12">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Проекты отделения</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($branch->projects as $project)
                                        <div class="bg-gray-50 rounded-lg p-6">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                                <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600">
                                                    {{ $project->name }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 mb-3">
                                                {{ Str::limit($project->short_description, 100) }}
                                            </p>
                                            <a href="{{ route('projects.show', $project) }}" 
                                               class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center text-sm">
                                                Подробнее о проекте
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Events Gallery Placeholder -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Фотогалерея мероприятий</h2>
                            <div class="bg-gray-50 rounded-lg p-8 text-center">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Фотогалерея</h3>
                                <p class="text-gray-600">Фотографии с мероприятий отделения будут добавлены позже</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-6 sticky top-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Контактная информация</h3>
                            
                            <div class="space-y-4">
                                @if($branch->address)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-gray-400 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Адрес</div>
                                            <div class="text-sm text-gray-600">{{ $branch->address }}</div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($branch->phone)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-gray-400 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Телефон</div>
                                            <div class="text-sm text-gray-600">{{ $branch->phone }}</div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($branch->email)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-gray-400 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Email</div>
                                            <div class="text-sm text-gray-600">{{ $branch->email }}</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Регион</div>
                                        <div class="text-sm text-gray-600">{{ $branch->region }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6 mt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Поделиться</h4>
                                <div class="flex space-x-3">
                                    <a href="https://vk.com/share.php?url={{ urlencode(request()->url()) }}&title={{ urlencode($branch->name) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-700 text-sm">
                                        ВКонтакте
                                    </a>
                                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($branch->name) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-700 text-sm">
                                        Telegram
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Other Branches -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Другие отделения</h2>
                
                @php
                    $otherBranches = App\Models\Branch::where('id', '!=', $branch->id)
                        ->orderBy('name')
                        ->limit(3)
                        ->get();
                @endphp

                @if($otherBranches->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($otherBranches as $otherBranch)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="p-6">
                                    <div class="text-sm text-blue-600 font-medium mb-2">{{ $otherBranch->region }}</div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                        <a href="{{ route('branches.show', $otherBranch) }}" class="hover:text-blue-600">
                                            {{ $otherBranch->name }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        {{ Str::limit($otherBranch->short_description, 80) }}
                                    </p>
                                    <a href="{{ route('branches.show', $otherBranch) }}" 
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
                    <a href="{{ route('branches') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Все отделения
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>