<?php

namespace Obelaw\Catalog\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Obelaw\Catalog\Models\Product;

class ProductRelatedRelation extends RelationManager
{
    protected static ?string $title = 'Related Products';
    protected static ?string $description = 'heroicon-o-archive-box';
    protected static string $relationship = 'related';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('related_id')
                    ->label('Product')
                    ->live()
                    ->options(Product::pluck('name', 'id'))
                    ->required(),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('related.name')
                    ->label('Name')
                    ->searchable(),

                TextColumn::make('related.inventory_sku')
                    ->label('SKU')
                    ->searchable(),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->groupedBulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
