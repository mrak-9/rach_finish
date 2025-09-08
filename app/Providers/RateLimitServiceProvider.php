<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        $config = config('rate_limiting');
        
        // Базовый API лимит
        RateLimiter::for('api', function (Request $request) use ($config) {
            $limit = $config['api']['default'] ?? 60;
            return Limit::perMinute($limit)->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) use ($config) {
                    return response()->json([
                        'message' => $config['messages']['api_limit'] ?? 'Rate limit exceeded',
                        'retry_after' => $headers['Retry-After'] ?? 60,
                    ], 429, $headers);
                });
        });

        // Строгие ограничения для операций записи
        RateLimiter::for('api-write', function (Request $request) use ($config) {
            $limit = $config['api']['write'] ?? 10;
            return Limit::perMinute($limit)->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) use ($config) {
                    return response()->json([
                        'message' => $config['messages']['api_write_limit'] ?? 'Write operations rate limit exceeded',
                        'retry_after' => $headers['Retry-After'] ?? 60,
                    ], 429, $headers);
                });
        });

        // Очень строгие ограничения для чувствительных операций (5 запросов в минуту)
        RateLimiter::for('api-sensitive', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Превышен лимит для чувствительных операций. Попробуйте через несколько минут.',
                        'retry_after' => $headers['Retry-After'] ?? 60,
                    ], 429, $headers);
                });
        });

        // Авторизованные пользователи (30 запросов в минуту)
        RateLimiter::for('api-auth', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Превышен лимит запросов для авторизованных пользователей.',
                        'retry_after' => $headers['Retry-After'] ?? 60,
                    ], 429, $headers);
                });
        });

        // Административные операции (3 запроса в минуту)
        RateLimiter::for('api-admin', function (Request $request) {
            return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Превышен лимит для административных операций.',
                        'retry_after' => $headers['Retry-After'] ?? 60,
                    ], 429, $headers);
                });
        });

        // Веб-формы (защита от спама - 20 запросов в минуту)
        RateLimiter::for('web-forms', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'message' => 'Превышен лимит отправки форм. Попробуйте позже.',
                            'retry_after' => $headers['Retry-After'] ?? 60,
                        ], 429, $headers);
                    }
                    
                    return back()->withErrors([
                        'rate_limit' => 'Превышен лимит отправки форм. Попробуйте через минуту.'
                    ])->withHeaders($headers);
                });
        });

        // Загрузка файлов (строгие ограничения - 5 запросов в 10 минут)
        RateLimiter::for('file-upload', function (Request $request) {
            return Limit::perMinutes(10, 5)->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Превышен лимит загрузки файлов. Попробуйте через 10 минут.',
                        'retry_after' => $headers['Retry-After'] ?? 600,
                    ], 429, $headers);
                });
        });

        // Поиск (умеренные ограничения - 100 запросов в минуту)
        RateLimiter::for('search', function (Request $request) {
            return Limit::perMinute(100)->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Превышен лимит поисковых запросов.',
                        'retry_after' => $headers['Retry-After'] ?? 60,
                    ], 429, $headers);
                });
        });

        // Регистрация на мероприятия (защита от множественных регистраций)
        RateLimiter::for('event-registration', function (Request $request) {
            return [
                // По IP - 10 регистраций в час
                Limit::perHour(10)->by($request->ip()),
                // По пользователю - 5 регистраций в час
                Limit::perHour(5)->by($request->user()?->id ?: $request->ip()),
            ];
        });

        // Отправка email (защита от спама)
        RateLimiter::for('email-sending', function (Request $request) {
            return Limit::perHour(5)->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Превышен лимит отправки email. Попробуйте через час.',
                        'retry_after' => $headers['Retry-After'] ?? 3600,
                    ], 429, $headers);
                });
        });

        // Авторизация (защита от брутфорса)
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            
            return [
                // По email - 5 попыток в минуту
                Limit::perMinute(5)->by($email.$request->ip()),
                // По IP - 10 попыток в минуту
                Limit::perMinute(10)->by($request->ip()),
            ];
        });

        // Восстановление пароля
        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perHour(3)->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return back()->withErrors([
                        'email' => 'Превышен лимит запросов на восстановление пароля. Попробуйте через час.'
                    ])->withHeaders($headers);
                });
        });
    }
}