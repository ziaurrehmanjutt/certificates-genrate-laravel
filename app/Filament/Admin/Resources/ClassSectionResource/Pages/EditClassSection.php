<?php

namespace App\Filament\Admin\Resources\ClassSectionResource\Pages;

use App\Filament\Admin\Resources\ClassSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassSection extends EditRecord
{
    protected static string $resource = ClassSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
