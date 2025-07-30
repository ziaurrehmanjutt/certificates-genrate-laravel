<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StudentDynamicFieldResource\Pages;
use App\Filament\Admin\Resources\StudentDynamicFieldResource\RelationManagers;
use App\Models\StudentDynamicField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Get;

use ValentinMorice\FilamentJsonColumn\JsonColumn;
use ValentinMorice\FilamentJsonColumn\JsonInfolist;



class StudentDynamicFieldResource extends Resource
{
    protected static ?string $model = StudentDynamicField::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('key')
                ->required()
                ->unique()
                ->label('Field Key'),

            Toggle::make('is_required')
                ->label('Is Required'),


            Fieldset::make('Label (Multi-language)')
                ->schema([
                    TextInput::make('label.en')
                        ->label('English')
                        ->suffix('🇬🇧')
                        ->required(),

                    TextInput::make('label.ar')
                        ->label('Arabic')
                        ->suffix('🇸🇦')
                        ->required(),
                ]),



            Group::make([
                Select::make('type')
                    ->options([
                        'text' => 'Text',
                        'longtext' => 'Long Text',
                        'number' => 'Number',
                        'date' => 'Date',
                        'image' => 'Image',
                    ])
                    ->required()
                    ->live(),

                // English input
                TextInput::make('default_value')
                    ->label('Default (English)')
                    ->visible(fn(Get $get) => in_array($get('type'), ['text', 'number']))
                    ->numeric(fn(Get $get) => $get('type') === 'number'),

                Textarea::make('default_value')
                    ->label('Default (English)')
                    ->visible(fn(Get $get) => $get('type') === 'longtext'),

                DatePicker::make('default_value')
                    ->label('Default (English)')
                    ->visible(fn(Get $get) => $get('type') === 'date'),

                FileUpload::make('default_value')
                    ->label('Default (English)')
                    ->visible(fn(Get $get) => $get('type') === 'image'),


            ])
                ->columns(2)
                ->columnSpanFull(),





            Fieldset::make('Help Text (Multi-language)')
                ->schema([
                    Textarea::make('help_text.en')
                        ->label('English')
                        // ->suffix('🇬🇧')
                        ->rows(3),

                    Textarea::make('help_text.ar')
                        ->label('Arabic')
                        // ->suffix('🇸🇦')
                        ->rows(3),
                ]),




        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->searchable(),
                TextColumn::make('label')
                    ->label('Label')
                    ->formatStateUsing(function ($record) {
                        $locale = app()->getLocale();
                        return $record->label[$locale] ?? $record->label['en'] ?? '—';
                    }),
                TextColumn::make('type'),
                IconColumn::make('is_required')->boolean(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStudentDynamicFields::route('/'),
            'create' => Pages\CreateStudentDynamicField::route('/create'),
            'edit' => Pages\EditStudentDynamicField::route('/{record}/edit'),
        ];
    }
}
