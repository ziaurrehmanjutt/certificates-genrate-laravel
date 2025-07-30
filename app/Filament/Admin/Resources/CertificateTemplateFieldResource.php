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

use Filament\Forms\Components\{Select, TextInput, Textarea, Toggle, Fieldset, Group, Grid};
use Filament\Forms\Get;
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
                    return \App\Models\CertificateTemplate::all()
                        ->mapWithKeys(fn($template) => [$template->id => $template->name[$locale] ?? 'Unnamed']);
                }),

            TextInput::make('key')
                ->required()
                ->unique()
                ->label('Field Key'),

            Fieldset::make('Label (Multi-language)')
                ->schema([
                    TextInput::make('label.en')
                        ->label('English')
                        ->required(),

                    TextInput::make('label.ur')
                        ->label('Urdu'),
                ]),

            Select::make('type')
                ->options([
                    'text' => 'Text',
                    'image' => 'Image',
                    'date' => 'Date',
                ])
                ->required()
                ->live(),

            Select::make('source_type')
                ->label('Source Type')
                ->options([
                    'static' => 'Static Value',
                    'system' => 'Student Field',
                    'custom' => 'Student Extra Field',
                ])
                ->required()
                ->live(),

            // If source_type is 'system', allow choosing predefined student fields
            Select::make('source_key')
                ->label('System Field')
                ->options([
                    'name' => 'Student Name',
                    'roll_no' => 'Roll Number',
                    'std_cnic' => 'CNIC',
                    'dob' => 'Date of Birth',
                    'std_class' => 'Class',
                    'std_program' => 'Program',
                ])
                ->visible(fn(Get $get) => $get('source_type') === 'system'),

            // If source_type is 'custom', show student extra fields (you may want to fetch these dynamically)
            Select::make('source_key')
                ->label('Custom Field')
                ->options(function (Get $get) {
                    if ($get('source_type') !== 'custom') {
                        return [];
                    }

                    $type = $get('type'); // e.g., text, image, date
                    return \App\Models\StudentDynamicField::query()
                        ->when($type, fn($query) => $query->where('type', $type))
                        ->get()
                        ->mapWithKeys(fn($field) => [$field->key => $field->label['en'] ?? $field->key]);
                })
                ->visible(fn(Get $get) => $get('source_type') === 'custom')
                ->reactive() // refresh when `type` changes
                ->live()
                ->required(),

            // Static value inputs
            Fieldset::make('Default Value (Multi-language)')
                ->schema([
                    TextInput::make('default_value.en')
                        ->label('English'),
                    TextInput::make('default_value.ur')
                        ->label('Urdu'),
                ])
                ->visible(fn(Get $get) => $get('source_type') === 'static'),

            Fieldset::make('Help Text (Multi-language)')
                ->schema([
                    Textarea::make('help_text.en')
                        ->label('English')
                        ->rows(3),
                    Textarea::make('help_text.ur')
                        ->label('Urdu')
                        ->rows(3),
                ]),

            Toggle::make('is_required')
                ->label('Required'),
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
