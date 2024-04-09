<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use App\Models\Team;
use App\Models\User;
use Filament\Tables;
use App\Models\TeamUser;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\Companies;
use Filament\Tables\Table;
// use App\Models\Role;
// use App\Models\Permission;
use App\Models\CompanyUser;
use Filament\Resources\Resource;
use App\Models\ClientInformation;
use Spatie\Permission\Models\Role;
use App\Models\EmployeeInformation;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Permission;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletes;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\CompanyUserResource\Pages;
use App\Filament\App\Resources\CompanyUserResource\RelationManagers;
use App\Filament\Resources\CompanyUserResource\Pages\EditCompanyUser;
use App\Filament\Resources\CompanyUserResource\Pages\ListCompanyUsers;
use App\Filament\Resources\CompanyUserResource\Pages\CreateCompanyUser;
use App\Filament\Resources\TeamUserResource\RelationManagers\RoleRelationManager;
use App\Filament\Resources\TeamUserResource\RelationManagers\TeamUserRelationManager;
use App\Filament\Resources\TeamUserResource\RelationManagers\ClientInformationRelationManager;
use App\Filament\Resources\TeamUserResource\RelationManagers\EmployeeInformationRelationManager;



class CompanyUserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel ='User';

    protected static ?string $modelLabel = 'User';

    protected static ?string $slug = 'Team-user';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255),
                        CheckboxList::make('user_roles')
                            ->relationship('roles', 'name')
                            ->columns(4)
                            ->helperText('Only Choose One!')
                            ->label('Roles')
                            ->required()
                            ->options(function () {
                                // Fetch roles and filter based on specific conditions
                                return Role::whereNotIn('name', ['super-admin'])
                                    ->get()
                                    ->pluck('name', 'id')
                                    ->toArray();
                            }),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable(),
                TextColumn::make('email')->sortable()
                ->icon('heroicon-m-envelope')
                ->iconColor('primary'),
                TextColumn::make('roles.name')
                ->sortable()

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
{
    return [

    ];
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyUsers::route('/'),
            'create' => Pages\CreateCompanyUser::route('/create'),
            'edit' => Pages\EditCompanyUser::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has the admin role
        if ($user && $user->hasRole('admin')) {
            return true; // User has admin role, can create
        } else {
            return false; // User does not have admin role, cannot create
        }
    }





}

