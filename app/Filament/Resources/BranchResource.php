<?php

namespace App\Filament\Resources;

use App\Models\Branch;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Отделения РАЧ';

    protected static ?string $modelLabel = 'Отделение';

    protected static ?string $pluralModelLabel = 'Отделения';

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
            'index' => \App\Filament\Resources\BranchResource\Pages\ListBranchs::route('/'),
            'create' => \App\Filament\Resources\BranchResource\Pages\CreateBranch::route('/create'),
            'edit' => \App\Filament\Resources\BranchResource\Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}