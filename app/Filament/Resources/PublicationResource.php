<?php

namespace App\Filament\Resources;

use App\Models\Publication;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Публикации';

    protected static ?string $modelLabel = 'Публикация';

    protected static ?string $pluralModelLabel = 'Публикации';

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
            'index' => \App\Filament\Resources\PublicationResource\Pages\ListPublications::route('/'),
            'create' => \App\Filament\Resources\PublicationResource\Pages\CreatePublication::route('/create'),
            'edit' => \App\Filament\Resources\PublicationResource\Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}