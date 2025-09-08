<?php

namespace App\Filament\Resources;

use App\Models\Publication;
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

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Публикации';

    protected static ?string $modelLabel = 'Публикация';

    protected static ?string $pluralModelLabel = 'Публикации';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Слаг')
                    ->maxLength(255)
                    ->helperText('Оставьте пустым для автоматической генерации'),
                Textarea::make('short_description')
                    ->label('Краткое описание')
                    ->rows(3)
                    ->maxLength(500),
                RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->label('Дата публикации')
                    ->default(now()),
                FileUpload::make('cover_image')
                    ->label('Обложка')
                    ->image()
                    ->directory('publications/covers'),
                Repeater::make('files')
                    ->label('Файлы')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название файла')
                            ->required(),
                        FileUpload::make('path')
                            ->label('Файл')
                            ->directory('publications/files')
                            ->required(),
                        TextInput::make('description')
                            ->label('Описание'),
                    ])
                    ->columnSpanFull(),
                Toggle::make('requires_membership')
                    ->label('Требует членство')
                    ->default(false),
                Toggle::make('is_published')
                    ->label('Опубликовано')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('short_description')
                    ->label('Краткое описание')
                    ->limit(100)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('requires_membership')
                    ->label('Требует членство')
                    ->boolean(),
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
                Tables\Filters\TernaryFilter::make('requires_membership')
                    ->label('Требует членство'),
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
            ->defaultSort('published_at', 'desc');
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