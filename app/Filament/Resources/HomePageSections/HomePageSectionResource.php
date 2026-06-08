<?php

namespace App\Filament\Resources\HomePageSections;

use App\Filament\Resources\HomePageSections\Pages\CreateHomePageSection;
use App\Filament\Resources\HomePageSections\Pages\EditHomePageSection;
use App\Filament\Resources\HomePageSections\Pages\ListHomePageSections;
use App\Filament\Resources\HomePageSections\Schemas\HomePageSectionForm;
use App\Filament\Resources\HomePageSections\Tables\HomePageSectionsTable;
use App\Models\HomePageSection;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HomePageSectionResource extends Resource
{
    protected static ?string $model = HomePageSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Master data';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Homepage Sections';

    protected static ?string $modelLabel = 'Homepage Section';

    protected static ?string $pluralModelLabel = 'Homepage Sections';

    public static function form(Schema $schema): Schema
    {
        return HomePageSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HomePageSectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHomePageSections::route('/'),
            'create' => CreateHomePageSection::route('/create'),
            'edit' => EditHomePageSection::route('/{record}/edit'),
        ];
    }
}
