<?php

namespace App\Filament\Admin\Resources\CertificateTemplateResource\Pages;

use App\Filament\Admin\Resources\CertificateTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCertificateTemplates extends ListRecords
{
    protected static string $resource = CertificateTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
