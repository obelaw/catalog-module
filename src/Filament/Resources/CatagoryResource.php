<?php

namespace Obelaw\Catalog\Filament\Resources;

use App\Concerns\HasDBTenancy;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Obelaw\Catalog\Filament\Clusters\CatalogCluster;
use Obelaw\Catalog\Filament\Resources\CatagoryResource\ListCatagory;
use Obelaw\Catalog\Models\Catagory;

class CatagoryResource extends Resource
{
    use HasDBTenancy;

    protected static ?int $navigationSort = 2;
    protected static ?string $cluster = CatalogCluster::class;
    protected static ?string $model = Catagory::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('parent_id')
                    ->label('Parent')
                    ->options(Catagory::all()->pluck('name', 'id'))
                    ->searchable(),

                TextInput::make('name')
                    ->label('Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('parent.name')->label('Name'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCatagory::route('/'),
            // 'create' => CreateCustomerAddress::route('/create'),
            // 'edit' => EditCustomerAddress::route('/{record}/edit'),
        ];
    }
}
