<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static string $view = 'filament.admin.pages.manage-settings';
    protected static ?string $title = 'App Settings';

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                TextInput::make('app_name')
                    ->label('Application Name')
                    ->required(),
                FileUpload::make('login_logo')
                    ->image()
                    ->directory('settings')
                    ->label('Login Logo')
                    ->maxFiles(1),
                FileUpload::make('navbar_logo')
                    ->image()
                    ->label('Navbar Logo'),
                FileUpload::make('favicon')
                    ->image()
                    ->label('Favicon'),
                ColorPicker::make('navbar_color')
                    ->label('Navbar Color')
                    ->default('#111827'),
                ColorPicker::make('primary_color')
                    ->label('Primary Color')
                    ->default('#fbbf24'),
                TextInput::make('certificate_prefix')
                    ->label('Certificate Prefix')
                    ->default('SCH'),
                TextInput::make('certificate_sequence')
                    ->numeric()
                    ->label('Certificate Starting Number')
                    ->default(1000),
            ])
            ->statePath('data');
    }

    public $data = [];

    public function mount(): void
    {
        $this->data = [
            'app_name' => setting('app_name', 'My Certificate System'),
            'login_logo' => setting('login_logo'),
            'navbar_logo' => setting('navbar_logo'),
            'favicon' => setting('favicon'),
            'navbar_color' => setting('navbar_color', '#111827'),
            'primary_color' => setting('primary_color', '#fbbf24'),
            'certificate_prefix' => setting('certificate_prefix', 'SCH'),
            'certificate_sequence' => setting('certificate_sequence', 1000),
        ];
    }

    public function save()
    {
        foreach ($this->data as $key => $value) {

            if (in_array($key, ['login_logo', 'navbar_logo', 'favicon']) && is_array($value)) {
                $value = $value[0] ?? null;
            }

            \App\Models\Setting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        \Filament\Notifications\Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    // protected function getFormActions(): array
    // {
    //     return [
    //         \Filament\Forms\Components\Actions\Button::make('save')
    //             ->label('Save Settings')
    //             ->submit('save'),
    //     ];
    // }
}

