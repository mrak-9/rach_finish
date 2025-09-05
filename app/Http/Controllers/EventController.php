<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    private $eventsPath = 'events';

    public function index()
    {
        $events = $this->getEventsFromFileSystem();
        
        // Пагинация вручную
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $total = count($events);
        $events = array_slice($events, ($currentPage - 1) * $perPage, $perPage);
        
        return view('events.index', compact('events', 'total', 'currentPage', 'perPage'));
    }

    public function show($eventSlug)
    {
        $eventPath = storage_path('app/public/' . $this->eventsPath . '/' . $eventSlug);
        
        if (!File::exists($eventPath)) {
            abort(404, 'Мероприятие не найдено');
        }

        $event = $this->getEventDetails($eventSlug);
        
        return view('events.show', compact('event'));
    }

    private function getEventsFromFileSystem()
    {
        $eventsPath = storage_path('app/public/' . $this->eventsPath);
        
        if (!File::exists($eventsPath)) {
            File::makeDirectory($eventsPath, 0755, true);
            return [];
        }

        $events = [];
        $directories = File::directories($eventsPath);

        foreach ($directories as $directory) {
            $eventName = basename($directory);
            $event = $this->getEventDetails($eventName);
            if ($event) {
                $events[] = $event;
            }
        }

        // Сортируем по имени (можно изменить логику сортировки)
        usort($events, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $events;
    }

    private function getEventDetails($eventSlug)
    {
        $eventPath = storage_path('app/public/' . $this->eventsPath . '/' . $eventSlug);
        
        if (!File::exists($eventPath)) {
            return null;
        }

        $event = [
            'slug' => $eventSlug,
            'name' => str_replace(['_', '-'], ' ', $eventSlug),
            'description' => '',
            'images' => [],
            'branches' => []
        ];

        // Читаем описание из текстового файла
        $descriptionFile = $eventPath . '/description.txt';
        if (File::exists($descriptionFile)) {
            $event['description'] = File::get($descriptionFile);
        }

        // Получаем изображения
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $files = File::files($eventPath);
        
        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            if (in_array($extension, $imageExtensions)) {
                $fileName = $file->getFilename();
                $imageName = pathinfo($fileName, PATHINFO_FILENAME);
                
                $event['images'][] = [
                    'filename' => $fileName,
                    'path' => 'storage/' . $this->eventsPath . '/' . $eventSlug . '/' . $fileName,
                    'caption' => str_replace(['_', '-'], ' ', $imageName)
                ];
            }
        }

        // Получаем связанные отделения (пример логики)
        // В реальности это может быть более сложная логика
        $event['branches'] = $this->getRelatedBranches($eventSlug);

        return $event;
    }

    private function getRelatedBranches($eventSlug)
    {
        // Простая логика связи отделений с мероприятиями
        // В реальности это может быть настроено через админ панель
        return \App\Models\Branch::limit(3)->get();
    }
}
