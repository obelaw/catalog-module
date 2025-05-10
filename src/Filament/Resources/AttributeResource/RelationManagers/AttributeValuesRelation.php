<?php

namespace Obelaw\Catalog\Filament\Resources\AttributeResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Obelaw\Catalog\Models\Attribute;

class AttributeValuesRelation extends RelationManager
{
    protected static ?string $title = 'Attribute Values';
    protected static ?string $description = 'heroicon-o-archive-box';
    protected static string $relationship = 'values';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->options->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('value')
                    ->required(),
            ])->columns(1);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('value')
                    ->label('Value')
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
