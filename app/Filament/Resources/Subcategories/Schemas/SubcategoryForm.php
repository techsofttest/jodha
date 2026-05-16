<?php

namespace App\Filament\Resources\Subcategories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;

class SubcategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('subcat_cat_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('subcat_name')
                    ->required()
                    ->live(onBlur: true) // triggers update when user leaves field
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('subcat_slug', Str::slug($state));
                    }),

                TextInput::make('subcat_slug')
                    ->hidden() // hides from UI
                    ->unique(ignoreRecord: true)
                    ->dehydrated(), // still saved to DB F

                Textarea::make('subcat_description')
                    ->default(null)
                    ->columnSpanFull(),

                FileUpload::make('subcat_image')
                    ->disk('public')
                    ->image(),

                // TextInput::make('subcat_slug')
                //     ->required(),

                TextInput::make('meta_title')
                    ->default(null),

                Textarea::make('meta_description')
                    ->default(null)
                    ->columnSpanFull(),

                TextInput::make('meta_keywords')
                    ->default(null),

            ]);
    }
}
