<?php

namespace App\Filament\Admin\Resources\CertificateTemplateFieldResource\Pages;

use App\Filament\Admin\Resources\CertificateTemplateFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCertificateTemplateFields extends ListRecords
{
    protected static string $resource = CertificateTemplateFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
