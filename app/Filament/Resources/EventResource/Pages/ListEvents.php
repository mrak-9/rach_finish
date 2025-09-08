<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Получить данные для таблицы
     */
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return EventResource::getEloquentQuery();
    }

    /**
     * Получить записи для отображения
     */
    protected function getTableRecords(): \Illuminate\Support\Collection
    {
        return Event::all();
    }
}