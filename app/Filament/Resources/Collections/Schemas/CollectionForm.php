<?php

namespace App\Filament\Resources\Collections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class CollectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('col_cat_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(), // 👈 important


                Select::make('col_subcat_id')
                    ->label('Subcategory')
                    ->relationship(
                        name: 'subcategory',
                        titleAttribute: 'subcat_name',
                        modifyQueryUsing: function ($query, callable $get) {
                            $categoryId = $get('col_cat_id');

                            if ($categoryId) {
                                $query->where('subcat_cat_id', $categoryId);
                            }
                        }
                    )
                    ->required()
                    ->searchable()
                    ->preload()
                    ->reactive(), // 👈 important

                TextInput::make('col_name')
                    ->label('Name')
                    ->required()
                    ->live(onBlur: true) // triggers update when user leaves field
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('col_slug', Str::slug($state));
                    }),

                TextInput::make('col_slug')
                    ->label('Slug')
                    ->hidden() // hides from UI
                    ->unique(ignoreRecord: true)
                    ->dehydrated(), // still saved to DB F

                Toggle::make('col_is_featured')
                    ->label('Featured')
                    ->default(false),

                Textarea::make('col_description')
                    ->label('Description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('col_image')
                    ->label('Image')
                    ->disk('public')
                    ->image()
                    ->required(),
                // TextInput::make('col_slug')
                //     ->required(),
                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->default(null),
                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('meta_keywords')
                    ->label('Meta Keywords')
                    ->default(null),
            ]);
    }
}
