<?php

namespace App\Filament\Resources;

use App\Models\Branch;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Отделения';

    protected static ?string $modelLabel = 'Отделение';

    protected static ?string $pluralModelLabel = 'Отделения';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Слаг')
                    ->maxLength(255)
                    ->helperText('Оставьте пустым для автоматической генерации'),
                TextInput::make('region')
                    ->label('Регион')
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                Textarea::make('address')
                    ->label('Адрес')
                    ->rows(3),
                Textarea::make('short_description')
                    ->label('Краткое описание')
                    ->rows(3),
                RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Опубликовано')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('region')
                    ->label('Регион')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Опубликовано'),
                Tables\Filters\SelectFilter::make('region')
                    ->label('Регион')
                    ->options(function () {
                        return Branch::distinct('region')
                            ->whereNotNull('region')
                            ->pluck('region', 'region')
                            ->toArray();
                    }),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\BranchResource\Pages\ListBranches::route('/'),
            'create' => \App\Filament\Resources\BranchResource\Pages\CreateBranch::route('/create'),
            'edit' => \App\Filament\Resources\BranchResource\Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}