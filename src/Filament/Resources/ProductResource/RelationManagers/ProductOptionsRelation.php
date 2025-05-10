<?php

namespace Obelaw\Catalog\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Obelaw\Catalog\Enums\OptionsPriceType;
use Obelaw\Catalog\Models\Attribute;
use Obelaw\Catalog\Models\AttributeValue;

class ProductOptionsRelation extends RelationManager
{
    protected static ?string $title = 'Options Products';
    protected static ?string $description = 'heroicon-o-archive-box';
    protected static string $relationship = 'options';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->options->count();
    } 

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('attribute_id')
                    ->label('Attribute')
                    ->live()
                    ->options(Attribute::pluck('name', 'id'))
                    ->required(),

                Select::make('attribute_value_id')
                    ->label('Value')
                    ->options(fn(Get $get) => AttributeValue::where('attribute_id', operator: $get('attribute_id'))->pluck('value', 'id'))
                    ->required()
                    ->disabled(fn(Get $get) => !$get('attribute_id')),

                TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->disabled(fn(Get $get) => !$get('attribute_id')),

                Toggle::make('has_special_price')
                    ->live()
                    ->label('Has Special Price')
                    ->disabled(fn(Get $get) => !$get('attribute_id')),

                Select::make('type_price')
                    ->label('Type Price')
                    ->options(OptionsPriceType::class)
                    ->required()
                    ->visible(fn(Get $get) => $get('has_special_price')),

                TextInput::make('special_price')
                    ->label('Special Price')
                    ->required()
                    ->visible(fn(Get $get) => $get('has_special_price')),
            ])->columns(1);
    }


    public function table(Table $table): Table
    {
        return $table
            ->defaultGroup('attribute.name')
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),

                TextColumn::make('attribute.name')
                    ->label('Attribute')
                    ->searchable(),

                TextColumn::make('attributeValue.value')
                    ->label('Value')
                    ->searchable(),

                TextColumn::make('type_price')
                    ->label('Type Price')
                    ->badge(),

                TextColumn::make('special_price')
                    ->label('Special Price')
                    ->money('EGP')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->groupedBulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
