<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StandardProduct
 *
 * @property int $id
 * @property string $name
 * @property int|null $team_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StandardProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StandardProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StandardProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StandardProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StandardProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StandardProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StandardProduct whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StandardProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read InfoProduct                                     $info
 */
class StandardProduct extends Model
{
    protected $fillable = [
        'name',
        'team_id'
    ];

    public function order()
    {
        return $this->morphOne(Order::class, 'orderable');
    }

	public function info()
	{
		return $this->morphOne(InfoProduct::class, 'infoable');
	}
}
