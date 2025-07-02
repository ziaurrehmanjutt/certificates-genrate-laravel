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
        return $form
            ->schema([
                TextInput::make('certificate_no')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required(),
                Select::make('template_id')
                    ->relationship('certificateTemplate', 'name')
                    ->required()
                    ->label('Certificate Template'),
                DatePicker::make('issued_date'),
                FileUpload::make('qr_code_path')
                    ->directory('qrcodes')
                    ->label('QR Code')
                    ->image()
                    ->maxSize(1024),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('description')
                ->limit(50),
        ])
        ->filters([])
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
