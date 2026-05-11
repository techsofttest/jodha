<?php

namespace App\Filament\Resources\JournalCategories;

use App\Filament\Resources\JournalCategories\Pages\CreateJournalCategory;
use App\Filament\Resources\JournalCategories\Pages\EditJournalCategory;
use App\Filament\Resources\JournalCategories\Pages\ListJournalCategories;
use App\Filament\Resources\JournalCategories\Schemas\JournalCategoryForm;
use App\Filament\Resources\JournalCategories\Tables\JournalCategoriesTable;
use App\Models\JournalCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JournalCategoryResource extends Resource
{
    protected static ?string $model = JournalCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Article Categories';

    protected static ?string $pluralLabel = 'Article Categories';

    protected static ?string $singularLabel = 'Article Category';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return JournalCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JournalCategoriesTable::configure($table);
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
            'index' => ListJournalCategories::route('/'),
            'create' => CreateJournalCategory::route('/create'),
            'edit' => EditJournalCategory::route('/{record}/edit'),
        ];
    }
}
