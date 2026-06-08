<?php

namespace App\Filament\Resources\HomePageSections\Schemas;

use App\Models\Category;
use App\Models\Collection;
use App\Models\HomePageSection;
use App\Models\Subcategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HomePageSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Trending Products, New Arrivals'),

                Select::make('section_type')
                    ->label('Section Type')
                    ->options([
                        'category' => 'Category',
                        'subcategory' => 'Sub Category',
                        'collection' => 'Collection',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (callable $set) => $set('reference_id', null)),

                Select::make('reference_id')
                    ->label('Reference Item')
                    ->required()
                    ->searchable()
                    ->options(function (callable $get) {
                        $type = $get('section_type');

                        if (!$type) {
                            return [];
                        }

                        return match ($type) {
                            'category' => Category::pluck('name', 'id')->toArray(),
                            'subcategory' => Subcategory::pluck('subcat_name', 'id')->toArray(),
                            'collection' => Collection::pluck('col_name', 'id')->toArray(),
                            default => [],
                        };
                    }),

                TextInput::make('product_limit')
                    ->label('Product Limit')
                    ->numeric()
                    ->required()
                    ->default(5)
                    ->minValue(1)
                    ->maxValue(20),

                /*Toggle::make('status')
                    ->label('Active')
                    ->default(true),*/

            ]);
    }
}
