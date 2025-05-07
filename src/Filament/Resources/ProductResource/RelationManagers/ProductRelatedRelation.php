<?php

namespace Obelaw\Catalog\Filament\Resources\ProductResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductRelatedRelation extends RelationManager
{
    protected static ?string $title = 'Related Products';
    protected static ?string $description = 'heroicon-o-archive-box';
    protected static string $relationship = 'related';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('related.name')
                    ->label('Name')
                    ->searchable(),

                TextColumn::make('related.sku')
                    ->label('SKU')
                    ->searchable(),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Action::make('View')
                //     ->icon('heroicon-o-eye')
                //     ->color(Color::Gray)
                //     ->url(fn (Model $record) => route('filament.erp-o.resources.serials.view', $record)),

            ])
            ->groupedBulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
