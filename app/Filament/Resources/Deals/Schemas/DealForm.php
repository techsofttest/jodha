<?php

namespace App\Filament\Resources\Deals\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use App\Models\ProductSize;

class DealForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('deal_product_id')
    ->label('Product')
    ->relationship('product', 'prod_name')
    ->required()
    ->searchable()
    ->preload()
    ->live()
    ->afterStateUpdated(
        fn ($set) => $set('deal_product_size_id', null)
    ),

Select::make('deal_product_size_id')
    ->options(fn ($get) =>
        ProductSize::where('product_id', $get('deal_product_id'))
            ->pluck('size', 'id')
    )
    ->disabled(fn ($get) => !$get('deal_product_id'))
    ->searchable(),


                TextInput::make('deal_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                TextInput::make('deal_label')
                    ->required(),

                DatePicker::make('deal_date')
                    ->required(),
            ]);
    }
}
