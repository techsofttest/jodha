<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ToggleColumn;


class ProductsTable
{
    public static function configure(Table $table): Table
{
    return $table
        ->defaultSort('id', 'desc')
        ->columns([

            /* ================= IMAGE ================= */

            ImageColumn::make('prod_image')
                ->label('Image')
                ->square(),

            /* ================= PRODUCT ================= */

            TextColumn::make('prod_name')
                ->label('Product')
                ->searchable()
                ->sortable()
                ->limit(30),

            TextColumn::make('collection.col_name')
                ->label('Collection')
                ->sortable(),

            /* ================= PRICING ================= */

            TextColumn::make('prod_sale_price')
                ->label('Offer Price')
                ->money('INR')
                ->sortable(),
            
            /* ================= ACTIVE TOGGLE ================= */

            ToggleColumn::make('prod_isactive')
                ->label('Active')
                ->sortable(),

            ToggleColumn::make('prod_home')
                ->label('Home Product')
                ->sortable(),
          
            /* ================= CREATED DATE ================= */

            TextColumn::make('created_at')
                ->label('Created')
                ->date()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])

        ->filters([
            //
        ])

        ->recordActions([
            EditAction::make(),
        ])

        ->toolbarActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ]);
}
}
