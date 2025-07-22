<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CertificateTemplateResource\Pages;
use App\Filament\Admin\Resources\CertificateTemplateResource\RelationManagers;
use App\Models\CertificateTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;

class CertificateTemplateResource extends Resource
{
    protected static ?string $model = CertificateTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\KeyValue::make('name')
                ->label('Name (Multi-language)')
                ->keyLabel('Language Code (e.g., en, ur)')
                ->valueLabel('Name')
                ->required(),

            \Filament\Forms\Components\KeyValue::make('description')
                ->label('Description (Multi-language)')
                ->keyLabel('Language Code (e.g., en, ur)')
                ->valueLabel('Description'),

            \Filament\Forms\Components\FileUpload::make('background_image_path')
                ->image()
                ->label('Background Image')
                ->directory('certificate-backgrounds'),

            \Filament\Forms\Components\Select::make('orientation')
                ->options([
                    'landscape' => 'Landscape',
                    'portrait' => 'Portrait',
                ])
                ->required(),

            \Filament\Forms\Components\TextInput::make('font_family')
                ->label('Font Family'),

            \Filament\Forms\Components\KeyValue::make('extra_config')
                ->label('Extra Config (Optional JSON)')
                ->keyLabel('Config Key')
                ->valueLabel('Value'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->formatStateUsing(fn($state) => $state[app()->getLocale()] ?? '-')
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->formatStateUsing(fn($state) => $state[app()->getLocale()] ?? '-')
                    ->limit(40),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCertificateTemplates::route('/'),
            'create' => Pages\CreateCertificateTemplate::route('/create'),
            'edit' => Pages\EditCertificateTemplate::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manage Certificates';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-paint-brush';
    }
}
