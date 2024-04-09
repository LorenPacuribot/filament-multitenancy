<?php

namespace App\Filament\Resources\CompaniesResource\Pages;

use App\Filament\Resources\CompaniesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Artisan;
use App\Models\Team;

class CreateCompanies extends CreateRecord
{
    protected static string $resource = CompaniesResource::class;

    protected function getRedirectUrl(): string
    {
        // Get the created team (assuming Filament handles team creation)
        $team = $this->getCreatedTeam();

        if ($team) {
            // Set the 'SEEDER_TEAM_ID' environment variable
            putenv("SEEDER_TEAM_ID={$team->id}");

            // Array of seeders to run
            $seeders = [
               
                // Add more seeders as needed
            ];

            // Trigger each seeder after creating a company
            foreach ($seeders as $seeder) {
                $this->runSeeder($seeder);
            }

            // Unset the 'SEEDER_TEAM_ID' environment variable
            putenv('SEEDER_TEAM_ID');
        }

        // Redirect to the index page
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedTeam()
    {
        // Your logic to retrieve the created team
        // Replace the following line with your actual logic
        // For example, if Filament automatically creates the team, you might fetch it from the database
        return Team::latest()->first();
    }

    protected function runSeeder($seederClass)
    {
        // Run the specified seeder using Artisan command
        Artisan::call('db:seed', ['--class' => $seederClass]);

        // Unset the 'SEEDER_TEAM_ID' environment variable
        putenv('SEEDER_TEAM_ID');
    }
}
