<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class AboutUs extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.about-us';


    protected static ?string $navigationGroup = 'Information'; // group in sidebar


    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'About Us'; // title shown on page

}
