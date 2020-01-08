<?php

namespace App\Models;

use DB;
use App\User;
use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null                                          $created_at
 * @property Carbon|null                                          $updated_at
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string                                               $email
 * @property-read Collection|User[] $users
 * @method static Builder|Team whereEmail($value)
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CostCentre[] $cost_centres
 * @property-read int|null $cost_centres_count
 */
class Team extends Model
{
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * Returns the users via pivot.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function cost_centres(): HasMany
    {
        return $this->hasMany(\App\Models\CostCentre::class);
    }

    public function hours()
    {
        if ($this->id) {
            return DB::table('hours')
                     ->whereRaw(
                         'hours.user_id in (
                     SELECT id from users
                     WHERE users.id in (
                        SELECT user_id from team_user
                        where team_user.team_id = ' . $this->id . '
                        )
                    )'
                     )
                     ->get();
        }
    }
}
