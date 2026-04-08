<?php

namespace App\Filament\Resources\JournalCategories\Pages;

use App\Filament\Resources\JournalCategories\JournalCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJournalCategory extends EditRecord
{
    protected static string $resource = JournalCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
