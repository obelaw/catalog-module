<?php

namespace Obelaw\Catalog\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Obelaw\Catalog\Filament\Clusters\CatalogCluster;
use Obelaw\Catalog\Filament\Resources\AttributeResource\Pages;
use Obelaw\Catalog\Filament\Resources\AttributeResource\Pages\EditAttribute;
use Obelaw\Catalog\Filament\Resources\AttributeResource\Pages\ListAttributes;
use Obelaw\Catalog\Filament\Resources\AttributeResource\Pages\ViewAttribute;
use Obelaw\Catalog\Filament\Resources\AttributeResource\RelationManagers\AttributeValuesRelation;
use Obelaw\Catalog\Models\Attribute;
use Twist\Tenancy\Concerns\HasDBTenancy;

class AttributeResource extends Resource
{
    use HasDBTenancy;
    protected static ?int $navigationSort = 2;
    protected static ?string $cluster = CatalogCluster::class;
    protected static ?string $model = Attribute::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';
    protected static string | \UnitEnum | null $navigationGroup = 'Configuration';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AttributeValuesRelation::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttributes::route('/'),
            // 'create' => CreateCustomerAddress::route('/create'),
            'view' => ViewAttribute::route('/{record}'),
            'edit' => EditAttribute::route('/{record}/edit'),
        ];
    }
}
