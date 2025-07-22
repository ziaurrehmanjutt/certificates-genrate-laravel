<?php

namespace App\Filament\Admin\Resources\StudentDynamicFieldResource\Pages;

use App\Filament\Admin\Resources\StudentDynamicFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentDynamicField extends EditRecord
{
    protected static string $resource = StudentDynamicFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
