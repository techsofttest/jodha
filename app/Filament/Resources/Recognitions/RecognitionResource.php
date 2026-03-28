<?php

namespace App\Filament\Resources\Recognitions;

use App\Filament\Resources\Recognitions\Pages\CreateRecognition;
use App\Filament\Resources\Recognitions\Pages\EditRecognition;
use App\Filament\Resources\Recognitions\Pages\ListRecognitions;
use App\Filament\Resources\Recognitions\Schemas\RecognitionForm;
use App\Filament\Resources\Recognitions\Tables\RecognitionsTable;
use App\Models\Recognition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RecognitionResource extends Resource
{
    protected static ?string $model = Recognition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Recognitions';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return RecognitionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecognitionsTable::configure($table);
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
            'index' => ListRecognitions::route('/'),
            'create' => CreateRecognition::route('/create'),
            'edit' => EditRecognition::route('/{record}/edit'),
        ];
    }
}
