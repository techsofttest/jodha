<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                    /*TextInput::make('title')
                        ->maxLength(255),*/
                    FileUpload::make('image')
                        ->image()
                        ->disk('public')
                        ->directory('banners')
                        ->required(),
                    /*FileUpload::make('high_res_image')
                        ->image()
                        ->directory('banners'),*/
                    /*TextInput::make('link')
                        ->url()
                        ->maxLength(255),*/
                    /*TextInput::make('order')
                        ->numeric()
                        ->default(0),*/
                    /*Toggle::make('is_active')
                        ->default(true),*/
            ]);
    }
}
