<?php

namespace App\Filament\Resources;

use App\Models\Conference;
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

class ConferenceResource extends Resource
{
    protected static ?string $model = Conference::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Конференции';

    protected static ?string $modelLabel = 'Конференция';

    protected static ?string $pluralModelLabel = 'Конференции';

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
                DateTimePicker::make('registration_start_date')
                    ->label('Дата начала регистрации')
                    ->required(),
                DateTimePicker::make('conference_start_date')
                    ->label('Дата начала конференции')
                    ->required(),
                DateTimePicker::make('conference_end_date')
                    ->label('Дата окончания конференции'),
                TextInput::make('location')
                    ->label('Место проведения')
                    ->maxLength(255),
                Select::make('conference_type')
                    ->label('Тип конференции')
                    ->options([
                        'online' => 'Онлайн',
                        'offline' => 'Очно',
                        'hybrid' => 'Гибридная',
                    ]),
                RichEditor::make('announcement')
                    ->label('Анонс')
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull(),
                RichEditor::make('post_release')
                    ->label('Пост-релиз')
                    ->columnSpanFull(),
                Repeater::make('important_dates')
                    ->label('Важные даты')
                    ->schema([
                        DateTimePicker::make('date')
                            ->label('Дата')
                            ->required(),
                        TextInput::make('event')
                            ->label('Событие')
                            ->required(),
                    ])
                    ->columnSpanFull(),
                Repeater::make('events')
                    ->label('Мероприятия')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название')
                            ->required(),
                        Textarea::make('description')
                            ->label('Описание'),
                        DateTimePicker::make('start_time')
                            ->label('Время начала'),
                        DateTimePicker::make('end_time')
                            ->label('Время окончания'),
                    ])
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('registration_start_date')
                    ->label('Регистрация с')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conference_start_date')
                    ->label('Дата начала')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conference_end_date')
                    ->label('Дата окончания')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Место')
                    ->limit(30),
                Tables\Columns\TextColumn::make('conference_type')
                    ->label('Тип')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'online' => 'success',
                        'offline' => 'warning',
                        'hybrid' => 'info',
                        default => 'gray',
                    }),
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
                Tables\Filters\SelectFilter::make('conference_type')
                    ->label('Тип конференции')
                    ->options([
                        'online' => 'Онлайн',
                        'offline' => 'Очно',
                        'hybrid' => 'Гибридная',
                    ]),
                Tables\Filters\Filter::make('upcoming')
                    ->label('Предстоящие')
                    ->query(fn ($query) => $query->where('conference_start_date', '>=', now())),
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
            ->defaultSort('conference_start_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ConferenceResource\Pages\ListConferences::route('/'),
            'create' => \App\Filament\Resources\ConferenceResource\Pages\CreateConference::route('/create'),
            'edit' => \App\Filament\Resources\ConferenceResource\Pages\EditConference::route('/{record}/edit'),
        ];
    }
}