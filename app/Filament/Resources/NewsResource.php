<?php

namespace App\Filament\Resources;

use App\Models\News;
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

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Новости';

    protected static ?string $modelLabel = 'Новость';

    protected static ?string $pluralModelLabel = 'Новости';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->label('Заголовок')
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
                RichEditor::make('content')
                    ->label('Содержание')
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->label('Изображение')
                    ->image()
                    ->directory('news'),
                DateTimePicker::make('published_at')
                    ->label('Дата публикации')
                    ->default(now()),
                Toggle::make('is_published')
                    ->label('Опубликовано')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Изображение')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('short_description')
                    ->label('Краткое описание')
                    ->limit(100)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->dateTime()
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
                Tables\Filters\Filter::make('published_at')
                    ->form([
                        DateTimePicker::make('published_from')
                            ->label('Опубликовано с'),
                        DateTimePicker::make('published_until')
                            ->label('Опубликовано до'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn ($query, $date) => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn ($query, $date) => $query->whereDate('published_at', '<=', $date),
                            );
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
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\NewsResource\Pages\ListNews::route('/'),
            'create' => \App\Filament\Resources\NewsResource\Pages\CreateNews::route('/create'),
            'edit' => \App\Filament\Resources\NewsResource\Pages\EditNews::route('/{record}/edit'),
        ];
    }
}