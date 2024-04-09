<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\TeamUser;
use App\Models\Team;


class TeamUserRelationManager extends RelationManager
{
    protected static string $relationship = 'TeamUser';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('team_id')
                ->relationship('team', 'name')
                ->searchable()
                ->preload()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Team')
            ->columns([
                //Tables\Columns\TextColumn::make('team'),
                Tables\Columns\TextColumn::make('team.name') // Assuming the relationship is defined as 'team' in TeamUser model
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
