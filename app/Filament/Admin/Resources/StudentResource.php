<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StudentResource\Pages;
use App\Filament\Admin\Resources\StudentResource\RelationManagers;
use App\Models\Student;
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
use Filament\Tables\Columns\DateColumn;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('roll_no')
                    ->required()
                    ->maxLength(50),
                Select::make('program_id')
                    ->relationship('program', 'name')
                    ->required(),
                Select::make('class_id')
                    ->relationship('classSection', 'name')
                    ->required()
                    ->label('Class / Section'),
                TextInput::make('cnic')
                    ->maxLength(20)
                    ->label('CNIC'),
                DatePicker::make('dob')
                    ->label('Date of Birth'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
       ->columns([
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('roll_no')
                ->label('Roll No')
                ->searchable(),
            TextColumn::make('program.name')
                ->label('Program'),
            TextColumn::make('classSection.name')
                ->label('Class/Section'),
            TextColumn::make('cnic')
                ->label('CNIC')
                ->limit(20),
            TextColumn::make('dob')
              ->date('Y-m-d')
                ->label('Date of Birth'),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manage Certificates';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-users';
    }
}
