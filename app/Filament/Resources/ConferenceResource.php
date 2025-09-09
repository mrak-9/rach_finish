<?php

namespace App\Filament\Resources;

use App\Models\Conference;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;

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
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Место проведения')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_start_date')
                    ->label('Регистрация с')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conference_start_date')
                    ->label('Дата начала')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conference_end_date')
                    ->label('Дата окончания')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Опубликовано'),
                Tables\Filters\Filter::make('upcoming')
                    ->label('Предстоящие')
                    ->query(fn ($query) => $query->where('conference_start_date', '>=', now())),
                Tables\Filters\Filter::make('past')
                    ->label('Прошедшие')
                    ->query(fn ($query) => $query->where('conference_end_date', '<', now())),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('conference_start_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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