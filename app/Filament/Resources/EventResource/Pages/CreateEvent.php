<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    /**
     * Создать новое мероприятие
     */
    protected function handleRecordCreation(array $data): Model
    {
        // Создаем мероприятие
        $event = Event::create($data['name']);
        
        // Обновляем описание
        if (isset($data['description'])) {
            $event->updateDescription($data['description']);
        }
        
        // Добавляем изображения
        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $imagePath) {
                // Перемещаем файл из временной папки в папку мероприятия
                $fileName = basename($imagePath);
                $sourcePath = storage_path('app/public/' . $imagePath);
                $targetPath = $event->path . '/' . $fileName;
                
                if (file_exists($sourcePath)) {
                    \Illuminate\Support\Facades\Storage::move('public/' . $imagePath, $targetPath);
                }
            }
            
            // Перезагружаем изображения
            $event->loadImages();
        }
        
        return $event;
    }

    /**
     * Получить URL для редиректа после создания
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}