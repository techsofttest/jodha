<?php

namespace App\Filament\Resources\HomePageSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class HomePageSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('display_order')
            ->defaultSort('display_order', 'asc')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('section_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'category' => 'Category',
                        'subcategory' => 'Sub Category',
                        'collection' => 'Collection',
                        default => $state,
                    }),

                TextColumn::make('reference_name')
                    ->label('Reference Item')
                    ->getStateUsing(fn ($record) => $record->reference_name),

                TextColumn::make('product_limit')
                    ->label('Limit')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
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
