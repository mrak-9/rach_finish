<?php

namespace App\Filament\Resources\StaticPageResource\Pages;

use App\Filament\Resources\StaticPageResource;
use Filament\Resources\Pages\ListRecords;

class ListStaticPages extends ListRecords
{
    protected static string $resource = StaticPageResource::class;
}