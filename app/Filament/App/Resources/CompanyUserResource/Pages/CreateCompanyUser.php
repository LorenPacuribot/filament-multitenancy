<?php

namespace App\Filament\App\Resources\CompanyUserResource\Pages;

use App\Filament\App\Resources\CompanyUserResource;
use App\Models\TeamUser;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompanyUser extends CreateRecord
{
    protected static string $resource = CompanyUserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleCreate(array $data): array
    {
        // Create the user
        $user = parent::handleCreate($data);

        // Ensure the user has an 'id' before creating TeamUser
        if ($user->id) {
            // Attach the user to the team in the TeamUser pivot table with the same team_id
            TeamUser::create([
                'user_id' => $user->id,
                'team_id' => auth()->user()->team_id,
            ]);
        }

        return $user;
    }
}
