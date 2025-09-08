<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;
use App\Models\User;

class RateLimitingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Очищаем rate limiter перед каждым тестом
        RateLimiter::clear('api');
        RateLimiter::clear('api-write');
        RateLimiter::clear('api-sensitive');
        RateLimiter::clear('web-forms');
        RateLimiter::clear('login');
    }

    /**
     * Тест базового API rate limiting
     */
    public function test_api_rate_limiting()
    {
        // Делаем 60 запросов (лимит)
        for ($i = 0; $i < 60; $i++) {
            $response = $this->getJson('/api/events');
            $response->assertStatus(200);
        }

        // 61-й запрос должен быть заблокирован
        $response = $this->getJson('/api/events');
        $response->assertStatus(429);
        $response->assertJsonStructure([
            'message',
            'retry_after'
        ]);
    }

    /**
     * Тест строгих ограничений для операций записи
     */
    public function test_api_write_rate_limiting()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->create();
        
        // Делаем 10 запросов (лимит для записи)
        for ($i = 0; $i < 10; $i++) {
            $response = $this->postJson('/api/conferences/test-conference/register', [
                'name' => 'Test User',
                'email' => 'test@example.com'
            ]);
            // Может быть 404 если конференция не существует, но rate limiting должен работать
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        // 11-й запрос должен быть заблокирован
        $response = $this->postJson('/api/conferences/test-conference/register', [
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);
        $response->assertStatus(429);
    }

    /**
     * Тест очень строгих ограничений для чувствительных операций
     */
    public function test_api_sensitive_rate_limiting()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Делаем 5 запросов (лимит для чувствительных операций)
        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/api/events', [
                'name' => 'Test Event ' . $i,
                'description' => 'Test Description'
            ]);
            // Может быть разный статус, но не 429
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        // 6-й запрос должен быть заблокирован
        $response = $this->postJson('/api/events', [
            'name' => 'Test Event 6',
            'description' => 'Test Description'
        ]);
        $response->assertStatus(429);
    }

    /**
     * Тест ограничений для веб-форм
     */
    public function test_web_forms_rate_limiting()
    {
        // Делаем 20 запросов (лимит для веб-форм)
        for ($i = 0; $i < 20; $i++) {
            $response = $this->post('/membership/payment', [
                'amount' => 1000,
                'email' => 'test@example.com'
            ]);
            // Может быть разный статус, но не 429
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        // 21-й запрос должен быть заблокирован
        $response = $this->post('/membership/payment', [
            'amount' => 1000,
            'email' => 'test@example.com'
        ]);
        $this->assertEquals(429, $response->getStatusCode());
    }

    /**
     * Тест защиты от брутфорса при авторизации
     */
    public function test_login_rate_limiting()
    {
        // Делаем 5 неудачных попыток входа (лимит по email)
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrong-password'
            ]);
            // Может быть 422 (validation error) или редирект, но не 429
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        // 6-я попытка должна быть заблокирована
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password'
        ]);
        $this->assertEquals(429, $response->getStatusCode());
    }

    /**
     * Тест ограничений для восстановления пароля
     */
    public function test_password_reset_rate_limiting()
    {
        // Делаем 3 запроса на восстановление пароля (лимит в час)
        for ($i = 0; $i < 3; $i++) {
            $response = $this->post('/forgot-password', [
                'email' => 'test@example.com'
            ]);
            // Может быть разный статус, но не 429
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        // 4-й запрос должен быть заблокирован
        $response = $this->post('/forgot-password', [
            'email' => 'test@example.com'
        ]);
        $this->assertEquals(429, $response->getStatusCode());
    }

    /**
     * Тест ограничений для регистрации на мероприятия
     */
    public function test_event_registration_rate_limiting()
    {
        // Делаем 10 регистраций (лимит в час по IP)
        for ($i = 0; $i < 10; $i++) {
            $response = $this->post('/conferences/test-conference/register', [
                'name' => 'Test User ' . $i,
                'email' => 'test' . $i . '@example.com'
            ]);
            // Может быть разный статус, но не 429
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        // 11-я регистрация должна быть заблокирована
        $response = $this->post('/conferences/test-conference/register', [
            'name' => 'Test User 11',
            'email' => 'test11@example.com'
        ]);
        $this->assertEquals(429, $response->getStatusCode());
    }

    /**
     * Тест заголовков в ответах при превышении лимитов
     */
    public function test_rate_limit_headers()
    {
        // Превышаем лимит API
        for ($i = 0; $i <= 60; $i++) {
            $response = $this->getJson('/api/events');
        }

        $response = $this->getJson('/api/events');
        $response->assertStatus(429);
        
        // Проверяем наличие заголовков
        $response->assertHeader('Retry-After');
        
        // Проверяем структуру JSON ответа
        $response->assertJsonStructure([
            'message',
            'retry_after'
        ]);
        
        // Проверяем, что сообщение на русском языке
        $responseData = $response->json();
        $this->assertStringContainsString('Превышен лимит', $responseData['message']);
    }

    /**
     * Тест различных лимитов для авторизованных и неавторизованных пользователей
     */
    public function test_different_limits_for_authenticated_users()
    {
        $user = User::factory()->create();

        // Тест для неавторизованного пользователя (60 запросов)
        for ($i = 0; $i < 60; $i++) {
            $response = $this->getJson('/api/events');
            $response->assertStatus(200);
        }

        $response = $this->getJson('/api/events');
        $response->assertStatus(429);

        // Очищаем лимиты
        RateLimiter::clear('api');

        // Тест для авторизованного пользователя (30 запросов для auth endpoints)
        $this->actingAs($user, 'sanctum');
        
        for ($i = 0; $i < 30; $i++) {
            $response = $this->getJson('/api/user');
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        $response = $this->getJson('/api/user');
        $response->assertStatus(429);
    }
}