<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * App\User
 *
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @mixin \Eloquent
 * @property int                                                                                  $id
 * @property string                                                                               $name
 * @property string                                                                               $username
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Ability[] $abilities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $bedrijf
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIs($role)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsAll($role)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsNot($role)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,
        HasRolesAndAbilities;

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
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function bedrijf(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
