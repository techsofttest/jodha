<?php

namespace App\Filament\Resources\HomePageSections\Pages;

use App\Filament\Resources\HomePageSections\HomePageSectionResource;
use App\Models\HomePageSection;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateHomePageSection extends CreateRecord
{
    protected static string $resource = HomePageSectionResource::class;

    protected function beforeCreate(): void
    {
        if (HomePageSection::count() >= 5) {
            Notification::make()
                ->title('Maximum sections reached')
                ->body('You can only have up to 5 homepage sections. Please delete an existing section first.')
                ->danger()
                ->send();

            $this->halt();
        }
    }
}
