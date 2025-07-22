<?php

namespace App\Filament\Admin\Resources\CertificateTemplateFieldResource\Pages;

use App\Filament\Admin\Resources\CertificateTemplateFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificateTemplateField extends EditRecord
{
    protected static string $resource = CertificateTemplateFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
