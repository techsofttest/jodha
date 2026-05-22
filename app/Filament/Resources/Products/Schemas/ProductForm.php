<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use App\Models\Color;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\RichEditor;

use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /* ================= BASIC INFO ================= */

            Section::make('Basic Information')
                ->schema([


                    Grid::make(3)->schema([
                        
                        Grid::make(4)->schema([

                        Toggle::make('prod_isactive')
                            ->label('Product Active')
                            ->default(true)
                            ->inline(false),

                        Toggle::make('prod_home')
                            ->label('Home Product')
                            ->inline(false),


                            //Checkbox::make('prod_trending')
                                //->label('Trending'),

                            //Checkbox::make('prod_hotdeal')
                                //->label('Hot Deal'),

                            // Checkbox::make('prod_deal_of_day')
                            //     ->label('Deal of the Day'),

                            //Checkbox::make('prod_new_arrival')
                                //->label('New Arrival'),

                        ])->columnSpanFull(),

                        

                        Select::make('prod_cat_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(
                                fn($set) =>
                                $set('prod_subcat_id', null)
                            ),

                        Select::make('prod_subcat_id')
                            ->label('Subcategory')
                            ->relationship(
                                name: 'subcategory',
                                titleAttribute: 'subcat_name',
                                modifyQueryUsing: function ($query, callable $get) {
                                    if ($get('prod_cat_id')) {
                                        $query->where('subcat_cat_id', $get('prod_cat_id'));
                                    }
                                }
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(
                                fn($set) =>
                                $set('prod_col_id', null)
                            ),

                        Select::make('prod_col_id')
                            ->label('Collection')
                            ->relationship(
                                name: 'collection',
                                titleAttribute: 'col_name',
                                modifyQueryUsing: function ($query, callable $get) {
                                    if ($get('prod_subcat_id')) {
                                        $query->where('col_subcat_id', $get('prod_subcat_id'));
                                    }
                                }
                            )
                            ->searchable()
                            ->preload(),

                        Select::make('material_id')
                        ->label('Material')
                        ->relationship('material', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->columnSpanFull(),

                        TextInput::make('prod_name')
                            ->label('Product Name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, $set) =>
                                $set('prod_slug', Str::slug($state))
                            ),

                        TextInput::make('prod_sku_code')
                            ->label('SKU Code'),

                        TextInput::make('prod_slug')
                            ->hidden()
                            ->unique(ignoreRecord: true)
                            ->dehydrated(),

                    ])->columnSpanFull(),


                ])->columnSpanFull(),

            /* ================= PRICING ================= */

            Section::make('Pricing & Inventory')
                ->schema([

                    Grid::make(3)->schema([

                        TextInput::make('prod_price')
                            ->label('Regular Price')
                            ->required()
                            ->numeric()
                            ->prefix('₹'),

                        TextInput::make('prod_sale_price')
                            ->label('Sale Price')
                            ->numeric()
                            ->prefix('₹')
                            ->default(0)
                            ->dehydrateStateUsing(fn ($state) => $state == 0 ? null : $state),

                        TextInput::make('prod_offer')
                            ->label('Offer (%)')
                            ->numeric()
                            ->default(0)
                            ->hidden()
                            ->dehydrated(),

                        TextInput::make('prod_stock')
                            ->label('Stock Quantity')
                            ->numeric()
                            ->default(0)
                            ->hidden(),
                        
                        TextInput::make('shipping_cost')
                            ->label('Shipping Cost')
                            ->numeric()
                            ->default(0)
                            ->prefix('₹'),

                        TextInput::make('prod_expected_delivery')
                            ->label('Expected Delivery (Days)')
                            ->numeric()
                            ->hidden(),
                    ]),


                ])->columnSpanFull(),


            Section::make('Product Sizes')
                ->collapsible()
                ->schema([
                    Repeater::make('sizes')
                        ->relationship()
                        ->schema([
                            Grid::make(1)->schema([
                                TextInput::make('size')
                                    ->label('Size')
                                    ->required(),

                                /*TextInput::make('stock')
                                    ->label('Stock')
                                    ->numeric()
                                    ->default(0),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric(),

                                TextInput::make('offer')
                                    ->label('Offer')
                                    ->numeric(),

                                TextInput::make('offer_price')
                                    ->label('Sale Price')
                                    ->numeric(), */
                            ]),
                        ])
                        ->addActionLabel('Add Size')
                        ->defaultItems(0),
                ])->columnSpanFull(),

            Section::make('Product Colors')
                ->collapsible()
                ->schema([
                    Repeater::make('colors')
                        ->relationship()
                        ->schema([
                            Grid::make(2)->schema([
                                Select::make('color_name')
                                    ->label('Color Name')
                                    ->options(Color::pluck('name', 'name'))
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state) {
                                            $colorCode = Color::whereRaw('LOWER(name) = ?', [Str::lower($state)])->value('color_code');
                                            if ($colorCode && !str_starts_with($colorCode, '#')) {
                                                $colorCode = '#' . $colorCode;
                                            }
                                            $set('color_code', $colorCode);
                                        }
                                    })
                                    ->required(),

                                TextInput::make('color_code')
                                    ->label('Hex Code')
                                    ->readonly()
                                    ->dehydrated()
                                    ->afterStateHydrated(function ($set, $get, $state) {
                                        if (!$state && $get('color_name')) {
                                            $colorCode = Color::whereRaw('LOWER(name) = ?', [Str::lower($get('color_name'))])->value('color_code');
                                            if ($colorCode && !str_starts_with($colorCode, '#')) {
                                                $colorCode = '#' . $colorCode;
                                            }
                                            $set('color_code', $colorCode);
                                        }
                                    }),
                            ]),
                        ])
                        ->addActionLabel('Add Color')
                        ->defaultItems(0),
                ])->columnSpanFull(),
      

            /* ================= MEDIA ================= */

            Section::make('Product Media')
                ->schema([
                    FileUpload::make('prod_image')
                        ->label('Main Product Image')
                        ->disk('public')
                        ->image()->required(),
                ])->columnSpanFull(),


            /*Section::make('Product Gallery')
                ->collapsible()
                ->schema([
                    Repeater::make('images')
                        ->relationship()
                        ->schema([
                            FileUpload::make('image_path')
                                ->label('Gallery Image')
                                ->image()
                                ->directory('products/gallery')
                                ->disk('public'),
                                
                        ])
                        ->addActionLabel('Add Image')
                        ->defaultItems(0),
                ])->columnSpanFull(),*/

            /* ================= DETAILS ================= */

            Section::make('Product Details')
                ->schema([

                    RichEditor::make('prod_description')
                        ->label('Product Description')
                        ->columnSpanFull(),

                    RichEditor::make('prod_material')
                        ->label('Material Details')
                        ->columnSpanFull(),

                    RichEditor::make('prod_measurements')
                        ->label('Measurements')
                        ->columnSpanFull(),
                ])->columnSpanFull(),

            /* ================= SEO ================= */

            Section::make('SEO Settings')
                ->collapsible()
                ->collapsed()
                ->schema([
                    TextInput::make('meta_title')
                        ->label('Meta Title'),

                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->columnSpanFull(),

                    TextInput::make('meta_keywords')
                        ->label('Meta Keywords'),
                ])->columnSpanFull(),
        ]);
    }
}
