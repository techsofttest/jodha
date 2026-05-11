<?php

namespace App\Filament\Resources\Journals\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;

class JournalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Article title')
                    ->live(onBlur: true) // triggers update when user leaves field
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),

                Select::make('journal_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),

                TextInput::make('label')
                    ->label('Label')
                    ->default(null),
                DatePicker::make('date')->label('Date'),
                RichEditor::make('content')->label('Content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')->label('Image')
                    ->disk('public')
                    ->image()
                    ->required(),
                TextInput::make('slug')
                    ->hidden() // hides from UI
                    ->dehydrated(), // still saved to DB

                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->default(null),
                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->default(null),
                TextInput::make('meta_keywords')
                    ->label('Meta Keyword')
                    ->default(null),

            ]);
    }
}
