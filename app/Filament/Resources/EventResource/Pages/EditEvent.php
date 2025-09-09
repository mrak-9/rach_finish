<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->action(function () {
                    $this->getRecord()->delete();
                    return redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }

    /**
     * Получить запись для редактирования
     */
    public function getRecord(): Model
    {
        $slug = $this->getRouteParameter('record');
        $event = Event::findBySlug($slug);
        
        if (!$event) {
            abort(404, 'Мероприятие не найдено');
        }
        
        return $event;
    }

    /**
     * Заполнить форму данными записи
     */
    protected function fillForm(): void
    {
        $event = $this->getRecord();
        
        $this->form->fill([
            'name' => $event->name,
            'description' => $event->description,
            'images' => array_map(function ($image) {
                return str_replace(storage_path('app/'), '', $image['path']);
            }, $event->images),
        ]);
    }

    /**
     * Обновить запись
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Обновляем описание
        if (isset($data['description'])) {
            $record->updateDescription($data['description']);
        }
        
        // Добавляем новые изображения
        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $imagePath) {
                // Проверяем, не является ли это уже существующим изображением
                $isExisting = false;
                foreach ($record->images as $existingImage) {
                    if (str_contains($existingImage['path'], basename($imagePath))) {
                        $isExisting = true;
                        break;
                    }
                }
                
                // Если это новое изображение, перемещаем его
                if (!$isExisting) {
                    $fileName = basename($imagePath);
                    $sourcePath = storage_path('app/public/' . $imagePath);
                    $targetPath = $record->path . '/' . $fileName;
                    
                    if (file_exists($sourcePath)) {
                        \Illuminate\Support\Facades\Storage::move('public/' . $imagePath, $targetPath);
                    }
                }
            }
            
            // Перезагружаем изображения
            $record->loadImages();
        }
        
        return $record;
    }

    /**
     * Получить URL для редиректа после обновления
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}