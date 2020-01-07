<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InfoProduct
 *
 * @property int $id
 * @property string $infoable_type
 * @property int $infoable_id
 * @property string|null $description
 * @property string|null $options
 * @property string|null $format
 * @property string|null $attachment
 * @property int|null $cost_centre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $infoable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereCostCentre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereInfoableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereInfoableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $type
 * @property string|null $reference
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InfoProduct whereType($value)
 */
class InfoProduct extends Model
{
    protected $fillable = [
        'description',
        'options',
        'format',
        'attachment',
        'cost_centre'
    ];

    public function infoable()
    {
        return $this->morphTo();
    }
}
