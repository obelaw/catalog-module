<?php

namespace Obelaw\Catalog\Filament\Resources;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
use Obelaw\Catalog\Enums\ProductScope;
use Obelaw\Catalog\Enums\ProductType;
use Obelaw\Catalog\Filament\Clusters\CatalogCluster;
use Obelaw\Catalog\Filament\Resources\ProductResource\Pages;
use Obelaw\Catalog\Filament\Resources\ProductResource\RelationManagers\ProductOptionsRelation;
use Obelaw\Catalog\Filament\Resources\ProductResource\RelationManagers\ProductRelatedRelation;
use Obelaw\Catalog\Models\Catagory;
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
                Group::make()->schema([
                    Section::make('Product Information')
                        ->schema([
                            Select::make(name: 'category_id')
                                ->label('Catagory')
                                ->options(Catagory::all()->pluck('name', 'id'))
                                ->searchable(),

                            TextInput::make('name')
                                ->required(),
                        ]),

                    Section::make('Inventory')
                        ->schema([
                            TextInput::make('inventory_sku')
                                ->label('SKU')
                                ->required()
                                ->columnSpan(2),

                            TextInput::make('inventory_quantity')
                                ->label('Quantity')
                                ->columnSpan(1),

                            TextInput::make('inventory_safety_stock')
                                ->label('Safety stock')
                                ->columnSpan(1),

                        ])->columns(2),

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
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Product Selection')
                        ->schema([
                            Select::make('product_type')
                                ->live()
                                ->options(ProductType::class)
                                ->required(),

                            Select::make('product_scope')
                                ->options(ProductScope::class)
                                ->required(),
                        ]),

                    Section::make('Priceing Information')
                        ->schema([
                            Fieldset::make('Sold')
                                ->schema([
                                    Toggle::make('can_sold')
                                        ->live(),

                                    TextInput::make('price_sales')
                                        ->visible(fn(Get $get) => $get('can_sold')),

                                ])->columns(1),

                            Fieldset::make('Purchased')
                                ->schema([
                                    Toggle::make('can_purchased')
                                        ->live(),

                                    TextInput::make('price_purchase')
                                        ->visible(fn(Get $get) => $get('can_purchased')),
                                ])->columns(1),

                            // Fieldset::make('Product Can')
                            //     ->schema([
                            //         Toggle::make('can_sold'),
                            //         Toggle::make('can_purchased'),
                            //     ])->columns(1),

                            // Fieldset::make('Product Price')
                            //     ->schema([
                            //         TextInput::make('price_sales'),
                            //         TextInput::make('price_purchase'),
                            //     ])->columns(1),
                        ]),
                ])->columnSpan(1),

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

                TextColumn::make('sku')
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
            ProductOptionsRelation::class,
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
