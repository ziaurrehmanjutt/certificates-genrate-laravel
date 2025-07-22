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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Columns\TextColumn;



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

            KeyValue::make('label')
                ->label('Label (Multi-language)')
                ->keyLabel('Locale')
                ->valueLabel('Label'),

            Select::make('type')
                ->options([
                    'text' => 'Text',
                    'number' => 'Number',
                    'date' => 'Date',
                    'select' => 'Select (Dropdown)',
                ])
                ->required(),

            KeyValue::make('options')
                ->label('Options (if Select)'),

            KeyValue::make('default_value')
                ->label('Default Value (Multi-language)'),

            KeyValue::make('help_text')
                ->label('Help Text (Multi-language)'),

            Toggle::make('is_required')
                ->label('Is Required'),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->searchable(),
                TextColumn::make('label')
                    ->label('Label')
                    ->formatStateUsing(function ($state) {
                        return $state;
                        $locale = app()->getLocale();
                        $decoded = json_decode($state, true);
                        return $decoded[$locale] ?? $decoded['en'] ?? '—';
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
