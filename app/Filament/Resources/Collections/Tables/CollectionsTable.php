<?php

namespace App\Filament\Resources\Collections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
// use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CollectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('col_order')
            ->defaultSort('col_order', 'asc')
            ->columns([
                ImageColumn::make('col_image')
                    ->label('Image')
                    ->disk('public')
                    ->square(),

                TextColumn::make('col_name')
                 ->label('Collection')
                    ->searchable(),


                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                TextColumn::make('subcategory.subcat_name')
                     ->label('SubCategory')
                    ->sortable(),

                \Filament\Tables\Columns\ToggleColumn::make('col_is_featured')
                    ->label('Featured')
                    ->sortable(),

                TextColumn::make('col_slug')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('meta_title')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('meta_keywords')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
