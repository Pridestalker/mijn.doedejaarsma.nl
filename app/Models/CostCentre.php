<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CostCentre
 *
 * @property int $id
 * @property string $name
 * @property int|null $team_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CostCentre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CostCentre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CostCentre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CostCentre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CostCentre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CostCentre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CostCentre whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CostCentre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CostCentre extends Model
{
    protected $fillable = [
        'name',
        'team_id'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
