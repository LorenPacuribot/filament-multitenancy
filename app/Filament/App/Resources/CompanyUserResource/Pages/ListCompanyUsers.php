<?php

namespace App\Filament\App\Resources\CompanyUserResource\Pages;

use App\Filament\App\Resources\CompanyUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyUsers extends ListRecords
{
    protected static string $resource = CompanyUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
