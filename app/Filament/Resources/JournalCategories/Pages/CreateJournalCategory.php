<?php

namespace App\Filament\Resources\JournalCategories\Pages;

use App\Filament\Resources\JournalCategories\JournalCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJournalCategory extends CreateRecord
{
    protected static string $resource = JournalCategoryResource::class;
}
