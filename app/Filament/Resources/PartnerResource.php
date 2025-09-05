<?php

namespace App\Filament\Resources;

use App\Models\Partner;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Партнеры';

    protected static ?string $modelLabel = 'Партнер';

    protected static ?string $pluralModelLabel = 'Партнеры';

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
            'index' => \App\Filament\Resources\PartnerResource\Pages\ListPartners::route('/'),
            'create' => \App\Filament\Resources\PartnerResource\Pages\CreatePartner::route('/create'),
            'edit' => \App\Filament\Resources\PartnerResource\Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}