<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


class User extends Authenticatable implements HasTenants, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
         'team_id'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;
    }


    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams->contains($tenant);
    }


    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }elseif ($panel->getId() === 'app') {
            return !$this->isAdmin();
        }

     //   Logic for other panels if needed

        return true; // Allow access by default for other panels
    }


    private function isAdmin(): bool
    {
        return (bool) $this->is_admin; // Cast is_admin to boolean
    }



public function team()
{
    return $this->belongsTo(Team::class, 'team_id', 'id');
}

public function role()
{
    return $this->belongsTo(Role::class, 'role_id', 'id');
}

public function members(): BelongsToMany
{
    return $this->belongsToMany(User::class);
}

protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            // Check if the user has a team_id
            if ($user->team_id) {
                // Update the existing or create a new TeamUser record with the user_id
                $user->teamUser()->updateOrCreate(
                    ['team_id' => $user->team_id],
                    ['user_id' => $user->id]
                );
            }
        });
    }

    public function teamUser()
    {
        return $this->hasOne(TeamUser::class);
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

}
