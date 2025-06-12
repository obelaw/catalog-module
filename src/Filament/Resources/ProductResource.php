<?php

namespace Obelaw\Catalog\Filament\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Obelaw\Catalog\Enums\OptionsPriceType;
use Obelaw\Catalog\Enums\ProductScope;
use Obelaw\Catalog\Enums\ProductType;
use Obelaw\Catalog\Enums\StockType;
use Obelaw\Catalog\Filament\Clusters\CatalogCluster;
use Obelaw\Catalog\Filament\Resources\ProductResource\Pages;
use Obelaw\Catalog\Filament\Resources\ProductResource\RelationManagers\ProductOptionsRelation;
use Obelaw\Catalog\Filament\Resources\ProductResource\RelationManagers\ProductRelatedRelation;
use Obelaw\Catalog\Models\Attribute;
use Obelaw\Catalog\Models\AttributeValue;
use Obelaw\Catalog\Models\Catagory;
use Obelaw\Catalog\Models\ContactVendor;
use Obelaw\Catalog\Models\Product;
use Obelaw\Twist\Facades\Twist;

class ProductResource extends Resource
{
    protected static ?int $navigationSort = 1;
    protected static ?string $cluster = CatalogCluster::class;
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Information')
                    ->schema([
                        Select::make(name: 'category_id')
                            ->label('Catagory')
                            ->options(Catagory::all()->pluck('name', 'id'))
                            ->searchable(),

                        TextInput::make('name')
                            ->required(),

                        TextInput::make('inventory_sku')
                            ->label('SKU')
                            ->required(),
                    ])->columnSpan(2),

                Section::make('Product Selection')
                    ->schema([
                        Select::make('product_type')
                            ->live()
                            ->options(ProductType::class)
                            ->required(),

                        Select::make('product_scope')
                            ->options(ProductScope::class)
                            ->required(),

                        Select::make('stock_type')
                            ->options(StockType::class)
                            ->required(),
                    ])->columnSpan(1),

                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                Group::make()->schema([


                                    Section::make('Product Images')
                                        ->schema([
                                            FileUpload::make('thumbnail')
                                                ->label('Thumbnail')
                                                ->directory(Twist::getUploadDirectory()),

                                            FileUpload::make('gallery')
                                                ->label('Gallery')
                                                ->multiple()
                                                ->directory(Twist::getUploadDirectory()),
                                        ]),
                                ])->columnSpan(3),
                            ])->columns(3),

                        Tabs\Tab::make('Attributes & Variants')
                            ->icon('heroicon-m-list-bullet')
                            ->visible(fn(Get $get) => $get('product_type') == ProductType::CONFIGURABLE->value)
                            // ->badge(5)
                            ->schema([
                                Repeater::make('options')
                                    ->relationship()
                                    ->schema([
                                        Select::make('attribute_id')
                                            ->label('Attribute')
                                            ->options(Attribute::pluck('name', 'id'))
                                            ->required()
                                            ->live(),

                                        Select::make('attribute_value_id')
                                            ->label('Attribute Value')
                                            ->options(fn(Get $get) => AttributeValue::where('attribute_id', $get('attribute_id'))->pluck('value', 'id'))
                                            ->required()
                                            ->disabled(fn(Get $get) => !$get('attribute_id')),

                                        TextInput::make('sku')
                                            ->label('SKU')
                                            ->required()
                                            ->columnSpanFull(),

                                        Select::make('type_price')
                                            ->live()
                                            ->options(OptionsPriceType::class)
                                            ->live(),

                                        TextInput::make('special_price')
                                            ->label('Special Price')
                                            ->required(fn(Get $get) => $get('type_price')),
                                    ])
                                    ->defaultItems(0)
                                    ->columns(2)
                            ]),

                        Tabs\Tab::make('Sales')
                            ->icon('heroicon-m-currency-dollar')
                            // ->badge(5)
                            ->schema([
                                Section::make('Priceing Information')
                                    ->schema([
                                        Toggle::make('sales_can_sold')
                                            ->label('Can Sold')
                                            ->live(),

                                        TextInput::make('sales_sale_price')
                                            ->label('Price Sales')
                                            ->numeric()
                                            ->required(fn(Get $get) => $get('sales_can_sold'))
                                            ->visible(fn(Get $get) => $get('sales_can_sold')),

                                        Fieldset::make('Special')
                                            ->schema([
                                                TextInput::make('sales_special_price')
                                                    ->label('Special price')
                                                    ->numeric()
                                                    ->columnSpanFull(),

                                                DatePicker::make('sales_special_price_from')
                                                    ->label('Special Sales From'),

                                                DatePicker::make('sales_special_price_to')
                                                    ->label('Special Sales To'),
                                            ])->visible(fn(Get $get) => $get('sales_can_sold')),
                                    ]),
                            ]),

                        Tabs\Tab::make('Purchase')
                            ->icon('heroicon-m-currency-dollar')
                            // ->badge(5)
                            ->schema([
                                Section::make('Priceing Information')
                                    ->schema([
                                        Toggle::make('purchase_can_purchased')
                                            ->label('Can Purchased')
                                            ->live(),

                                        Repeater::make('vendors')
                                            ->relationship()
                                            ->visible(fn(Get $get) => $get('purchase_can_purchased'))
                                            ->schema([
                                                Select::make('vendor_id')
                                                    ->label('Vendor')
                                                    ->options(ContactVendor::pluck('name', 'id'))
                                                    ->required(),

                                                TextInput::make('purchase_price')
                                                    ->label('Price Purchase')
                                                    ->numeric()
                                                    ->required(),
                                            ])
                                            ->defaultItems(0)
                                            ->columns(2)


                                    ]),
                            ]),

                        Tabs\Tab::make('Inventory')
                            ->icon('heroicon-m-archive-box')
                            ->schema([
                                Section::make('Dimension')
                                    ->schema([
                                        TextInput::make('inventory_dimension_length')
                                            ->label('Length')
                                            ->numeric()
                                            ->columnSpan(2),

                                        TextInput::make('inventory_dimension_width')
                                            ->label('Width')
                                            ->numeric()
                                            ->columnSpan(2),

                                        TextInput::make('inventory_dimension_height')
                                            ->label('Height')
                                            ->numeric()
                                            ->columnSpan(2),

                                        TextInput::make('inventory_weight')
                                            ->label('Weight')
                                            ->numeric()
                                            ->columnSpan(1),

                                        TextInput::make('inventory_volume')
                                            ->label('Volume')
                                            ->numeric()
                                            ->columnSpan(1),

                                    ])->columns(2)
                                    ->columnSpan(2),

                                Section::make('Inventory')
                                    ->schema([
                                        TextInput::make('inventory_quantity')
                                            ->label('Quantity'),

                                        TextInput::make('inventory_safety_stock')
                                            ->label('Safety stock'),

                                    ])->columnSpan(1),
                            ])->columns(3),
                    ])->columnSpanFull()
                    ->persistTabInQueryString('tab')
                    ->contained(false),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('serials.serial')
                    ->searchable()
                    ->default('unserial'),

                TextColumn::make('catagory.name')
                    ->label('Catagory')
                    ->default('uncategory'),

                TextColumn::make('product_type')
                    ->badge(),

                TextColumn::make('product_scope')
                    ->badge(),

                TextColumn::make('stock_type')
                    ->badge(),

                TextColumn::make('inventory_sku')
                    ->label('SKU')
                    ->searchable(),

                TextColumn::make('name'),

                ColumnGroup::make('Product Can', [
                    IconColumn::make('can_sold')
                        ->label('Sold')
                        ->boolean()
                        ->tooltip('price_sales')
                        ->alignCenter(),

                    IconColumn::make('can_purchased')
                        ->label('Purchased')
                        ->boolean()
                        ->alignCenter(),
                ])->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('product_type')
                    ->multiple()
                    ->options(ProductType::class),

                SelectFilter::make('product_scope')
                    ->multiple()
                    ->options(ProductScope::class),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductRelatedRelation::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduct::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
