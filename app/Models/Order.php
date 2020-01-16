<?php

namespace App\Models;

use App\User;
use Eloquent;
use EloquentFilter\Filterable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Order
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property string                          $object_type
 * @property int                             $object_id
 * @property string                          $status
 * @property string                          $deadline
 * @property int                             $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent             $orderable
 * @method static Builder|Order filter($input = array(), $filter = null)
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|Order query()
 * @method static Builder|Order simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|Order whereBeginsWith($column, $value, $boolean = 'and')
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDeadline($value)
 * @method static Builder|Order whereEndsWith($column, $value, $boolean = 'and')
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereLike($column, $value, $boolean = 'and')
 * @method static Builder|Order whereObjectId($value)
 * @method static Builder|Order whereObjectType($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUpdatedBy($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 * @property string $orderable_type
 * @property int $orderable_id
 * @method static Builder|Order whereOrderableId($value)
 * @method static Builder|Order whereOrderableType($value)
 * @property-read \App\User|null $user
 * @property string|null $factuur
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereFactuur($value)
 */
class Order extends Model
{
    use Filterable;

    protected $fillable = [
        'user_id',
        'status',
        'deadline',
        'updated_by'
    ];

    public function orderable()
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
