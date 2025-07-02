<?php

namespace App\Filament\Admin\Resources\ClassSectionResource\Pages;

use App\Filament\Admin\Resources\ClassSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassSections extends ListRecords
{
    protected static string $resource = ClassSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
