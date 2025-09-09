<?php

namespace App\Filament\Resources;

use App\Models\Partner;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Партнеры';

    protected static ?string $modelLabel = 'Партнер';

    protected static ?string $pluralModelLabel = 'Партнеры';

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
                Textarea::make('description')
                    ->label('Описание')
                    ->rows(3),
                TextInput::make('website')
                    ->label('Веб-сайт')
                    ->url()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->tel()
                    ->maxLength(255),
                FileUpload::make('logo')
                    ->label('Логотип')
                    ->image()
                    ->directory('partners/logos'),
                TextInput::make('sort_order')
                    ->label('Порядок сортировки')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_published')
                    ->label('Опубликовано')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Логотип')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('website')
                    ->label('Веб-сайт')
                    ->url(fn ($record) => $record->website)
                    ->openUrlInNewTab()
                    ->limit(50),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
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
            ->defaultSort('sort_order', 'asc');
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