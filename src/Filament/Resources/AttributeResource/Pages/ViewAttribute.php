<?php

namespace Obelaw\Catalog\Filament\Resources\AttributeResource\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Obelaw\Catalog\Filament\Resources\AttributeResource;

class ViewAttribute extends ViewRecord
{
    protected static string $resource = AttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Schema $schema): Schema
    {
        return $infolist
            ->schema([
                Tabs::make('Tabs')->tabs([
                    Tab::make('Order Information')
                        ->icon('heroicon-m-user')
                        ->schema([
                            TextEntry::make('name'),

                        ])->columns(2),

                ]),
            ])->columns(1);
    }
}
