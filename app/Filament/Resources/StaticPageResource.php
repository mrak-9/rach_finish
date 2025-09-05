<?php

namespace App\Filament\Resources;

use App\Models\StaticPage;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StaticPageResource extends Resource
{
    protected static ?string $model = StaticPage::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Статические страницы';

    protected static ?string $modelLabel = 'Статическая страница';

    protected static ?string $pluralModelLabel = 'Статические страницы';

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
            'index' => \App\Filament\Resources\StaticPageResource\Pages\ListStaticPages::route('/'),
            'create' => \App\Filament\Resources\StaticPageResource\Pages\CreateStaticPage::route('/create'),
            'edit' => \App\Filament\Resources\StaticPageResource\Pages\EditStaticPage::route('/{record}/edit'),
        ];
    }
}