<?php

namespace App;

use App\Models\Hour;
use App\Models\Product;
use App\Models\Team;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Silber\Bouncer\Database\Role;

/**
 * App\User
 *
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @mixin Eloquent
 * @property int                                                        $id
 * @property string                                                     $name
 * @property string                                                     $username
 * @property string                                                                               $email
 * @property Carbon|null                                                                          $email_verified_at
 * @property string                                                                               $password
 * @property string|null                                                                          $remember_token
 * @property Carbon|null                                                                          $created_at
 * @property Carbon|null                                                                          $updated_at
 * @property int|null                                                                             $current_team_id
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrentTeamId($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @property-read Collection|Ability[]                                  $abilities
 * @property-read Collection|Product[]                                  $bedrijf
 * @property-read Collection|Role[]                                     $roles
 * @method static Builder|User whereIs($role)
 * @method static Builder|User whereIsAll($role)
 * @method static Builder|User whereIsNot($role)
 * @property-read Collection|Product[]                                  $products
 * @property-read Collection|Client[]                                   $clients
 * @property-read Collection|Token[]                                    $tokens
 * @property-read int|null $abilities_count
 * @property-read int|null $bedrijf_count
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hour[] $hours
 * @property-read int|null $hours_count
 * @property-read int|null $notifications_count
 * @property-read int|null $products_count
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @property-read int|null $teams_count
 * @property-read int|null $tokens_count
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,
        HasApiTokens,
        HasRolesAndAbilities,
        Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function bedrijf(): BelongsToMany
    {
        return $this->teams();
    }
    
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany( Team::class );
    }
    
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    
    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class);
    }
    
    /*
     * Impersonation
     */
    public function canImpersonate(): bool
    {
        return in_array( 'admin', $this->getRoles()->toArray(), true );
    }
}
