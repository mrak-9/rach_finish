<?php

namespace App\Filament\Resources;

use App\Models\Project;
use App\Models\Branch;
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

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Проекты';

    protected static ?string $modelLabel = 'Проект';

    protected static ?string $pluralModelLabel = 'Проекты';

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
                DateTimePicker::make('start_date')
                    ->label('Дата начала'),
                DateTimePicker::make('end_date')
                    ->label('Дата окончания'),
                Select::make('status')
                    ->label('Статус')
                    ->options([
                        'planning' => 'Планирование',
                        'active' => 'Активный',
                        'completed' => 'Завершен',
                        'cancelled' => 'Отменен',
                    ])
                    ->default('planning'),
                Select::make('branches')
                    ->label('Отделения')
                    ->relationship('branches', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                FileUpload::make('featured_image')
                    ->label('Изображение')
                    ->image()
                    ->directory('projects'),
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
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('branches.name')
                    ->label('Отделения')
                    ->badge()
                    ->separator(','),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'planning' => 'gray',
                        'active' => 'success',
                        'completed' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Дата начала')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Дата окончания')
                    ->date()
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
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'planning' => 'Планирование',
                        'active' => 'Активный',
                        'completed' => 'Завершен',
                        'cancelled' => 'Отменен',
                    ]),
                Tables\Filters\SelectFilter::make('branches')
                    ->label('Отделения')
                    ->relationship('branches', 'name')
                    ->multiple(),
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
            ->defaultSort('start_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ProjectResource\Pages\ListProjects::route('/'),
            'create' => \App\Filament\Resources\ProjectResource\Pages\CreateProject::route('/create'),
            'edit' => \App\Filament\Resources\ProjectResource\Pages\EditProject::route('/{record}/edit'),
        ];
    }
}