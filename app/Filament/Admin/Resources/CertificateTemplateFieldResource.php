<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CertificateTemplateFieldResource\Pages;
use App\Filament\Admin\Resources\CertificateTemplateFieldResource\RelationManagers;
use App\Models\CertificateTemplateField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Models\CertificateTemplate;

class CertificateTemplateFieldResource extends Resource
{
    protected static ?string $model = CertificateTemplateField::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-columns';
    protected static ?string $navigationLabel = 'Certificate Template Fields';
    protected static ?string $pluralLabel = 'Certificate Template Fields';



    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('template_id')
                ->label('Certificate Template')
                ->required()
                ->options(function () {
                    $locale = app()->getLocale();

                    return CertificateTemplate::all()
                        ->mapWithKeys(function ($template) use ($locale) {
                            return [$template->id => $template->name[$locale] ?? 'Unnamed'];
                        });
                }),

            TextInput::make('key')
                ->required()
                ->unique(),

            TextInput::make('label.en')->label('Label (EN)')->required(),
            TextInput::make('label.ur')->label('Label (UR)'),

            Select::make('type')
                ->options([
                    'text' => 'Text',
                    'image' => 'Image',
                    'date' => 'Date',
                ])
                ->required(),

            Select::make('source_type')
                ->options([
                    'static' => 'Static Value',
                    'system' => 'System Field',
                    'custom' => 'Custom Field',
                ])
                ->required(),

            TextInput::make('source_key')->label('Source Key (if system/custom)')->nullable(),

            TextInput::make('default_value.en')->label('Default Value (EN)')->nullable(),
            TextInput::make('default_value.ur')->label('Default Value (UR)')->nullable(),

            Textarea::make('help_text.en')->label('Help Text (EN)')->nullable(),
            Textarea::make('help_text.ur')->label('Help Text (UR)')->nullable(),

            Forms\Components\Toggle::make('is_required')->label('Required'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('template.name')->label('Template'),
            Tables\Columns\TextColumn::make('key'),
            Tables\Columns\TextColumn::make('label')
                ->formatStateUsing(fn($state) => $state[app()->getLocale()] ?? '-'),

            Tables\Columns\TextColumn::make('type'),
            Tables\Columns\TextColumn::make('source_type'),
            Tables\Columns\BooleanColumn::make('is_required'),
        ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([]);
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
            'index' => Pages\ListCertificateTemplateFields::route('/'),
            'create' => Pages\CreateCertificateTemplateField::route('/create'),
            'edit' => Pages\EditCertificateTemplateField::route('/{record}/edit'),
        ];
    }
}
