<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DDoSProtection
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        
        // Проверяем подозрительную активность
        if ($this->isSuspiciousActivity($request, $ip, $userAgent)) {
            Log::warning('Подозрительная активность обнаружена', [
                'ip' => $ip,
                'user_agent' => $userAgent,
                'url' => $request->fullUrl(),
                'method' => $request->method()
            ]);
            
            return response()->json([
                'message' => 'Доступ временно ограничен из-за подозрительной активности.',
                'retry_after' => 3600
            ], 429);
        }
        
        // Отслеживаем активность
        $this->trackActivity($ip, $userAgent);
        
        return $next($request);
    }

    /**
     * Проверка подозрительной активности
     */
    private function isSuspiciousActivity(Request $request, string $ip, ?string $userAgent): bool
    {
        // 1. Проверка на слишком частые запросы (более 200 в минуту)
        $requestsPerMinute = Cache::get("ddos_requests_{$ip}", 0);
        if ($requestsPerMinute > 200) {
            return true;
        }
        
        // 2. Проверка на отсутствие User-Agent (боты)
        if (empty($userAgent)) {
            return true;
        }
        
        // 3. Проверка на подозрительные User-Agent
        $suspiciousUserAgents = [
            'curl', 'wget', 'python', 'bot', 'crawler', 'spider',
            'scraper', 'scanner', 'test', 'benchmark'
        ];
        
        foreach ($suspiciousUserAgents as $suspicious) {
            if (stripos($userAgent, $suspicious) !== false) {
                // Разрешаем некоторые легитимные боты
                $allowedBots = ['googlebot', 'bingbot', 'yandexbot', 'facebookexternalhit'];
                $isAllowedBot = false;
                
                foreach ($allowedBots as $allowedBot) {
                    if (stripos($userAgent, $allowedBot) !== false) {
                        $isAllowedBot = true;
                        break;
                    }
                }
                
                if (!$isAllowedBot) {
                    return true;
                }
            }
        }
        
        // 4. Проверка на одинаковые запросы от одного IP
        $sameRequestsKey = "ddos_same_requests_{$ip}_" . md5($request->fullUrl());
        $sameRequests = Cache::get($sameRequestsKey, 0);
        if ($sameRequests > 50) { // Более 50 одинаковых запросов в минуту
            return true;
        }
        
        // 5. Проверка на запросы к несуществующим страницам (сканирование)
        $notFoundKey = "ddos_404_{$ip}";
        $notFoundCount = Cache::get($notFoundKey, 0);
        if ($notFoundCount > 20) { // Более 20 запросов к несуществующим страницам в час
            return true;
        }
        
        return false;
    }

    /**
     * Отслеживание активности пользователя
     */
    private function trackActivity(string $ip, ?string $userAgent): void
    {
        // Счетчик запросов в минуту
        $requestsKey = "ddos_requests_{$ip}";
        $requests = Cache::get($requestsKey, 0);
        Cache::put($requestsKey, $requests + 1, 60); // 1 минута
        
        // Счетчик одинаковых запросов
        $request = request();
        $sameRequestsKey = "ddos_same_requests_{$ip}_" . md5($request->fullUrl());
        $sameRequests = Cache::get($sameRequestsKey, 0);
        Cache::put($sameRequestsKey, $sameRequests + 1, 60); // 1 минута
        
        // Отслеживание User-Agent
        if (!empty($userAgent)) {
            $userAgentKey = "ddos_user_agent_{$ip}";
            Cache::put($userAgentKey, $userAgent, 3600); // 1 час
        }
        
        // Логирование активности для анализа
        if ($requests > 100) { // Логируем высокую активность
            Log::info('Высокая активность пользователя', [
                'ip' => $ip,
                'requests_per_minute' => $requests,
                'user_agent' => $userAgent,
                'url' => $request->fullUrl()
            ]);
        }
    }

    /**
     * Обработка 404 ошибок для отслеживания сканирования
     */
    public static function track404(string $ip): void
    {
        $notFoundKey = "ddos_404_{$ip}";
        $notFoundCount = Cache::get($notFoundKey, 0);
        Cache::put($notFoundKey, $notFoundCount + 1, 3600); // 1 час
    }

    /**
     * Получение статистики по IP
     */
    public static function getIpStats(string $ip): array
    {
        return [
            'requests_per_minute' => Cache::get("ddos_requests_{$ip}", 0),
            'not_found_count' => Cache::get("ddos_404_{$ip}", 0),
            'user_agent' => Cache::get("ddos_user_agent_{$ip}", 'Unknown'),
        ];
    }
}