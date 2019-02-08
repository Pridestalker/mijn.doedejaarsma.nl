<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method   static Builder|Team newModelQuery()
 * @method   static Builder|Team newQuery()
 * @method   static Builder|Team query()
 * @method   static Builder|Team whereCreatedAt($value)
 * @method   static Builder|Team whereId($value)
 * @method   static Builder|Team whereName($value)
 * @method   static Builder|Team whereUpdatedAt($value)
 * @mixin    \Eloquent
 */
class Team extends Model
{
    //
    
    protected $fillable = [
        'name', 'email'
    ];
    
    /**
     * Returns the users via pivot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
