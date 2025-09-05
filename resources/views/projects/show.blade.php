<x-public-layout>
    <x-slot name="title">{{ $project->name }} - Наши проекты - Русская ассоциация чтения</x-slot>

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
                                <a href="{{ route('projects') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Наши проекты
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">
                                    {{ Str::limit($project->name, 30) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Project Header -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Активный проект</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        {{ $project->name }}
                    </h1>
                    @if($project->short_description)
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            {{ $project->short_description }}
                        </p>
                    @endif
                </div>
            </div>
        </section>

        <!-- Project Content -->
        <section class="pb-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <div class="prose prose-lg max-w-none">
                            @if($project->description)
                                {!! $project->description !!}
                            @else
                                <p class="text-gray-600">
                                    Подробная информация о проекте будет добавлена позже.
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-6 sticky top-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Информация о проекте</h3>
                            
                            @if($project->testing_info)
                                <div class="mb-6">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Апробация</h4>
                                    <p class="text-gray-600 text-sm">{{ $project->testing_info }}</p>
                                </div>
                            @endif

                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-2">Статус</h4>
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Активный</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-2">Контакты</h4>
                                <p class="text-gray-600 text-sm mb-1">Email: projects@rach.ru</p>
                                <p class="text-gray-600 text-sm">Телефон: +7 (495) 123-45-67</p>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Поделиться</h4>
                                <div class="flex space-x-3">
                                    <a href="https://vk.com/share.php?url={{ urlencode(request()->url()) }}&title={{ urlencode($project->name) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-700 text-sm">
                                        ВКонтакте
                                    </a>
                                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($project->name) }}" 
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

        <!-- Related Projects -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Другие проекты</h2>
                
                @php
                    $relatedProjects = App\Models\Project::where('id', '!=', $project->id)
                        ->orderBy('name')
                        ->limit(3)
                        ->get();
                @endphp

                @if($relatedProjects->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedProjects as $relatedProject)
                            <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="p-6">
                                    <div class="flex items-center mb-2">
                                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                        <span class="text-xs text-gray-500">Активный проект</span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                        <a href="{{ route('projects.show', $relatedProject) }}" class="hover:text-blue-600">
                                            {{ $relatedProject->name }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 text-sm">
                                        {{ Str::limit($relatedProject->short_description, 100) }}
                                    </p>
                                    <a href="{{ route('projects.show', $relatedProject) }}" 
                                       class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center text-sm">
                                        Подробнее
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                <div class="text-center mt-8">
                    <a href="{{ route('projects') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Все проекты
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-public-layout>