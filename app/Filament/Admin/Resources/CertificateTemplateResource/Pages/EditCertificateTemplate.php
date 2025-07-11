<?php

namespace App\Filament\Admin\Resources\CertificateTemplateResource\Pages;

use App\Filament\Admin\Resources\CertificateTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificateTemplate extends EditRecord
{
    protected static string $resource = CertificateTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
