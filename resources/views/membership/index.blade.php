<x-public-layout>
    <x-slot name="title">Членство в РАЧ - Русская ассоциация чтения</x-slot>

    <div class="bg-white">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Членство в РАЧ
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Присоединяйтесь к сообществу профессионалов в области чтения и образования
                    </p>
                </div>
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

        <!-- Membership Status -->
        @auth
            @if($currentMembership)
                <section class="bg-green-50 border-b border-green-200 py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-center">
                            <div class="flex items-center bg-white rounded-lg shadow-sm border border-green-200 px-6 py-4">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-green-800">Активное членство</h3>
                                    <p class="text-green-700">
                                        Действует до {{ $currentMembership->end_date->format('d.m.Y') }}
                                        ({{ $currentMembership->membership_type === 'individual' ? 'Индивидуальное' : 'Организация' }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endauth

        <!-- Membership Information -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($membershipPage && $membershipPage->content)
                    <div class="prose prose-lg max-w-none mb-12">
                        {!! $membershipPage->content !!}
                    </div>
                @else
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Преимущества членства</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Доступ к публикациям</h3>
                                <p class="text-gray-600">Скачивайте научные статьи и методические материалы</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Участие в конференциях</h3>
                                <p class="text-gray-600">Регистрируйтесь на закрытые мероприятия для членов</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Сертификаты</h3>
                                <p class="text-gray-600">Получайте сертификаты о прохождении мероприятий</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Payment Form -->
                @auth
                    @if($canPayMembership)
                        <div class="bg-gray-50 rounded-lg p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Оплата членства</h3>
                            
                            <form id="membership-form" action="{{ route('membership.payment') }}" method="POST" class="max-w-md mx-auto">
                                @csrf
                                
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Тип членства</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="membership_type" value="individual" class="mr-2" checked onchange="updateAmount()">
                                            <span>Индивидуальное (2000 руб./год)</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="membership_type" value="organization" class="mr-2" onchange="updateAmount()">
                                            <span>Организация (5000 руб./год)</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Сумма к оплате</label>
                                    <input type="number" id="amount" name="amount" value="2000" readonly 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                                </div>

                                <div class="space-y-4">
                                    <button type="submit" 
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                        Оплатить онлайн
                                    </button>
                                    
                                    <button type="button" onclick="generateQR()" 
                                            class="w-full bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                        Получить QR-код для оплаты
                                    </button>
                                </div>
                            </form>

                            <!-- QR Code Modal -->
                            <div id="qr-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
                                <div class="bg-white rounded-lg p-8 max-w-sm mx-4">
                                    <div class="text-center">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-4">QR-код для оплаты</h4>
                                        <div id="qr-code-container" class="mb-4"></div>
                                        <p class="text-sm text-gray-600 mb-4">Отсканируйте QR-код для оплаты</p>
                                        <button onclick="closeQRModal()" 
                                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                                            Закрыть
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
                        <h3 class="text-xl font-semibold text-yellow-800 mb-4">Для оплаты членства необходимо войти в систему</h3>
                        <a href="{{ route('login') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            Войти в систему
                        </a>
                    </div>
                @endauth
            </div>
        </section>

        <!-- Membership Types -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Типы членства</h2>
                    <p class="text-xl text-gray-600">Выберите подходящий тип членства</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Individual -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Индивидуальное</h3>
                            <div class="text-4xl font-bold text-blue-600 mb-4">2000 ₽</div>
                            <p class="text-gray-600 mb-6">в год</p>
                            
                            <ul class="text-left space-y-3 mb-8">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Доступ к публикациям
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Участие в конференциях
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Сертификаты участия
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Organization -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Организация</h3>
                            <div class="text-4xl font-bold text-blue-600 mb-4">5000 ₽</div>
                            <p class="text-gray-600 mb-6">в год</p>
                            
                            <ul class="text-left space-y-3 mb-8">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Все возможности индивидуального
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Корпоративные скидки
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Приоритетная поддержка
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function updateAmount() {
            const membershipType = document.querySelector('input[name="membership_type"]:checked').value;
            const amountField = document.getElementById('amount');
            
            if (membershipType === 'individual') {
                amountField.value = 2000;
            } else {
                amountField.value = 5000;
            }
        }

        function generateQR() {
            const form = document.getElementById('membership-form');
            const formData = new FormData(form);
            
            fetch('{{ route('membership.qr') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.qr_code) {
                    document.getElementById('qr-code-container').innerHTML = 
                        '<img src="' + data.qr_code + '" alt="QR код для оплаты" class="mx-auto">';
                    document.getElementById('qr-modal').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ошибка при генерации QR-кода');
            });
        }

        function closeQRModal() {
            document.getElementById('qr-modal').classList.add('hidden');
        }
    </script>
</x-public-layout>