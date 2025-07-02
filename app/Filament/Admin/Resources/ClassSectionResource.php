<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClassSectionResource\Pages;
use App\Filament\Admin\Resources\ClassSectionResource\RelationManagers;
use App\Models\ClassSection;
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

class ClassSectionResource extends Resource
{
    protected static ?string $model = ClassSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('program_id')
                    ->relationship('program', 'name')
                    ->required()
                    ->label('Program'),
                TextInput::make('year')
                    ->maxLength(10)
                    ->label('Session Year'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Section Name')
                    ->searchable(),
                TextColumn::make('program.name')
                    ->label('Program')
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Session Year'),
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
            'index' => Pages\ListClassSections::route('/'),
            'create' => Pages\CreateClassSection::route('/create'),
            'edit' => Pages\EditClassSection::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manage Certificates';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-rectangle-group';
    }

    public static function getNavigationLabel(): string
    {
        return 'Classes / Sections';
    }
}
