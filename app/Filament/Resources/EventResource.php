<?php

namespace App\Filament\Resources;

use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Support\Collection;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    
    protected static ?string $navigationLabel = 'Мероприятия (файлы)';
    
    protected static ?string $modelLabel = 'Мероприятие';
    
    protected static ?string $pluralModelLabel = 'Мероприятия';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название мероприятия')
                    ->required()
                    ->maxLength(255),
                    
                Textarea::make('description')
                    ->label('Описание')
                    ->required()
                    ->rows(10)
                    ->columnSpanFull(),
                    
                FileUpload::make('images')
                    ->label('Фотографии')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->directory('events')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->helperText('Загрузите фотографии с мероприятия. Поддерживаются форматы: JPG, PNG, GIF, WebP'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('description')
                    ->label('Описание')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                    
                TextColumn::make('images_count')
                    ->label('Фотографий')
                    ->getStateUsing(function ($record) {
                        return count($record->images);
                    })
                    ->badge()
                    ->color('success'),
                    
                ImageColumn::make('preview_image')
                    ->label('Превью')
                    ->getStateUsing(function ($record) {
                        $preview = $record->getPreviewImage();
                        return $preview ? $preview['url'] : null;
                    })
                    ->circular()
                    ->size(60),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn ($record) => $record->getUrl())
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->delete();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->delete();
                            }
                        }),
                ]),
            ]);
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    /**
     * Получить все записи для таблицы
     */
    public static function getEloquentQuery(): Builder
    {
        // Создаем фиктивный Builder для работы с файловой системой
        return new class extends Builder {
            public function __construct()
            {
                // Пустой конструктор
            }

            public function get($columns = ['*'])
            {
                return Event::all();
            }

            public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
            {
                $events = Event::all();
                $currentPage = $page ?: request()->get($pageName, 1);
                $total = $events->count();
                $offset = ($currentPage - 1) * $perPage;
                
                $items = $events->slice($offset, $perPage)->values();
                
                return new \Illuminate\Pagination\LengthAwarePaginator(
                    $items,
                    $total,
                    $perPage,
                    $currentPage,
                    [
                        'path' => request()->url(),
                        'pageName' => $pageName,
                    ]
                );
            }

            public function where($column, $operator = null, $value = null, $boolean = 'and')
            {
                return $this;
            }

            public function orderBy($column, $direction = 'asc')
            {
                return $this;
            }

            public function limit($value)
            {
                return $this;
            }

            public function offset($value)
            {
                return $this;
            }

            public function count()
            {
                return Event::all()->count();
            }
        };
    }
}