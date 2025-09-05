<?php

namespace App\Filament\Resources;

use App\Models\News;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Новости';

    protected static ?string $modelLabel = 'Новость';

    protected static ?string $pluralModelLabel = 'Новости';

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
            'index' => \App\Filament\Resources\NewsResource\Pages\ListNewss::route('/'),
            'create' => \App\Filament\Resources\NewsResource\Pages\CreateNews::route('/create'),
            'edit' => \App\Filament\Resources\NewsResource\Pages\EditNews::route('/{record}/edit'),
        ];
    }
}