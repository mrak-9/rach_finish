<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class Event
{
    public string $name;
    public string $slug;
    public string $description;
    public array $images;
    public string $path;

    public function __construct(string $name, string $path)
    {
        $this->name = $name;
        $this->slug = Str::slug($name);
        $this->path = $path;
        $this->loadDescription();
        $this->loadImages();
    }

    /**
     * Получить все мероприятия из файловой системы
     */
    public static function all(): Collection
    {
        $eventsPath = 'events';
        $directories = Storage::directories($eventsPath);
        
        $events = collect();
        
        foreach ($directories as $directory) {
            $eventName = basename($directory);
            $events->push(new self($eventName, $directory));
        }
        
        return $events->sortBy('name');
    }

    /**
     * Найти мероприятие по slug
     */
    public static function findBySlug(string $slug): ?self
    {
        return self::all()->first(function ($event) use ($slug) {
            return $event->slug === $slug;
        });
    }

    /**
     * Получить мероприятия с пагинацией
     */
    public static function paginate(int $perPage = 10): array
    {
        $events = self::all();
        $total = $events->count();
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $items = $events->slice($offset, $perPage)->values();
        
        return [
            'data' => $items,
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage),
            'has_more_pages' => $currentPage < ceil($total / $perPage),
        ];
    }

    /**
     * Загрузить описание из файла
     */
    private function loadDescription(): void
    {
        $descriptionFile = $this->path . '/description.txt';
        
        if (Storage::exists($descriptionFile)) {
            $this->description = Storage::get($descriptionFile);
        } else {
            $this->description = 'Описание мероприятия не найдено.';
        }
    }

    /**
     * Загрузить изображения из папки
     */
    public function loadImages(): void
    {
        $files = Storage::files($this->path);
        $this->images = [];
        
        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $this->images[] = [
                    'path' => $file,
                    'url' => Storage::url($file),
                    'caption' => $filename, // Название файла как подпись
                    'name' => basename($file),
                ];
            }
        }
    }

    /**
     * Получить краткое описание (первые 200 символов)
     */
    public function getShortDescription(): string
    {
        return Str::limit($this->description, 200);
    }

    /**
     * Получить первое изображение для превью
     */
    public function getPreviewImage(): ?array
    {
        return $this->images[0] ?? null;
    }

    /**
     * Получить все изображения для слайдера
     */
    public function getSliderImages(): array
    {
        return array_slice($this->images, 0, 5); // Максимум 5 изображений для слайдера
    }

    /**
     * Проверить, есть ли изображения
     */
    public function hasImages(): bool
    {
        return !empty($this->images);
    }

    /**
     * Получить URL для просмотра мероприятия
     */
    public function getUrl(): string
    {
        return route('events.show', $this->slug);
    }

    /**
     * Создать новое мероприятие (папку)
     */
    public static function create(string $name): self
    {
        $slug = Str::slug($name);
        $path = "events/{$name}";
        
        // Создаем папку
        Storage::makeDirectory($path);
        
        // Создаем файл описания по умолчанию
        Storage::put($path . '/description.txt', "Описание мероприятия: {$name}");
        
        return new self($name, $path);
    }

    /**
     * Удалить мероприятие (папку со всем содержимым)
     */
    public function delete(): bool
    {
        return Storage::deleteDirectory($this->path);
    }

    /**
     * Обновить описание мероприятия
     */
    public function updateDescription(string $description): bool
    {
        $result = Storage::put($this->path . '/description.txt', $description);
        if ($result) {
            $this->description = $description;
        }
        return $result;
    }

    /**
     * Добавить изображение к мероприятию
     */
    public function addImage($file, string $caption = null): bool
    {
        $filename = $caption ? Str::slug($caption) . '.' . $file->getClientOriginalExtension() : $file->getClientOriginalName();
        $path = $this->path . '/' . $filename;
        
        $result = Storage::putFileAs($this->path, $file, $filename);
        
        if ($result) {
            $this->loadImages(); // Перезагружаем изображения
        }
        
        return (bool) $result;
    }

    /**
     * Удалить изображение
     */
    public function removeImage(string $imagePath): bool
    {
        $result = Storage::delete($imagePath);
        
        if ($result) {
            $this->loadImages(); // Перезагружаем изображения
        }
        
        return $result;
    }
}