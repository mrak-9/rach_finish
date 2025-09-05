<?php

namespace App\Filament\Resources;

use App\Models\Conference;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ConferenceResource extends Resource
{
    protected static ?string $model = Conference::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Конференции';

    protected static ?string $modelLabel = 'Конференция';

    protected static ?string $pluralModelLabel = 'Конференции';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ConferenceResource\Pages\ListConferences::route('/'),
            'create' => \App\Filament\Resources\ConferenceResource\Pages\CreateConference::route('/create'),
            'edit' => \App\Filament\Resources\ConferenceResource\Pages\EditConference::route('/{record}/edit'),
        ];
    }
}