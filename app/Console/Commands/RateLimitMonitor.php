<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Http\Middleware\DDoSProtection;

class RateLimitMonitor extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'rate-limit:monitor 
                            {--ip= : Monitor specific IP address}
                            {--clear= : Clear statistics for IP address}
                            {--top=10 : Show top N active IPs}';

    /**
     * The console command description.
     */
    protected $description = 'Monitor rate limiting statistics and DDoS protection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('clear')) {
            $this->clearIpStats($this->option('clear'));
            return;
        }

        if ($this->option('ip')) {
            $this->showIpStats($this->option('ip'));
            return;
        }

        $this->showOverallStats();
    }

    /**
     * Show statistics for specific IP
     */
    private function showIpStats(string $ip): void
    {
        $this->info("Статистика для IP: {$ip}");
        $this->line('');

        $stats = DDoSProtection::getIpStats($ip);

        $this->table(
            ['Метрика', 'Значение'],
            [
                ['Запросов в минуту', $stats['requests_per_minute']],
                ['404 ошибок в час', $stats['not_found_count']],
                ['User-Agent', $stats['user_agent']],
            ]
        );
    }

    /**
     * Show overall statistics
     */
    private function showOverallStats(): void
    {
        $this->info('Общая статистика Rate Limiting');
        $this->line('');

        $config = config('rate_limiting');
        
        $this->table(
            ['Тип операции', 'Лимит', 'Период'],
            [
                ['API (чтение)', $config['api']['default'] ?? 60, '1 минута'],
                ['API (запись)', $config['api']['write'] ?? 10, '1 минута'],
                ['API (чувствительные)', $config['api']['sensitive'] ?? 5, '1 минута'],
                ['API (авторизованные)', $config['api']['auth'] ?? 30, '1 минута'],
                ['API (админ)', $config['api']['admin'] ?? 3, '1 минута'],
                ['Веб-формы', $config['web']['forms'] ?? 20, '1 минута'],
                ['Загрузка файлов', $config['web']['file_upload'] ?? 5, '10 минут'],
                ['Поиск', $config['web']['search'] ?? 100, '1 минута'],
            ]
        );

        $this->line('');
        $this->comment('Используйте --ip=<IP> для просмотра статистики конкретного IP');
        $this->comment('Используйте --clear=<IP> для очистки статистики IP');
    }

    /**
     * Clear statistics for IP
     */
    private function clearIpStats(string $ip): void
    {
        DDoSProtection::clearIpStats($ip);
        $this->info("Статистика для IP {$ip} очищена");
    }
}