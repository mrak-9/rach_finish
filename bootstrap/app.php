<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Настройка rate limiting для различных групп маршрутов
        $middleware->throttleApi();
        
        // Кастомные rate limiters
        $middleware->throttleWithRedis();
        
        // DDoS защита для всех маршрутов
        $middleware->append(\App\Http\Middleware\DDoSProtection::class);
        
        // Дополнительные middleware для безопасности
        $middleware->web(append: [
            \App\Http\Middleware\DDoSProtection::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
