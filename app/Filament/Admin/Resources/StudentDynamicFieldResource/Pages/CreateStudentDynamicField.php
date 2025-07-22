<?php

namespace App\Filament\Admin\Resources\StudentDynamicFieldResource\Pages;

use App\Filament\Admin\Resources\StudentDynamicFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentDynamicField extends CreateRecord
{
    protected static string $resource = StudentDynamicFieldResource::class;
}
