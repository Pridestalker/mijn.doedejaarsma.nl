<?php

namespace App\Models;

use App\User;
use Eloquent;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use App\Models\Order;

/**
 * App\Product
 *
 * @method static Builder|\App\Product newModelQuery()
 * @method static Builder|\App\Product newQuery()
 * @method static Builder|\App\Product query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $options
 * @property string $format
 * @property string $attachment
 * @property string $deadline
 * @property int $user_id
 * @property string $soort
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|\App\Product whereAttachment($value)
 * @method static Builder|\App\Product whereCreatedAt($value)
 * @method static Builder|\App\Product whereDeadline($value)
 * @method static Builder|\App\Product whereDescription($value)
 * @method static Builder|\App\Product whereFormat($value)
 * @method static Builder|\App\Product whereId($value)
 * @method static Builder|\App\Product whereName($value)
 * @method static Builder|\App\Product whereOptions($value)
 * @method static Builder|\App\Product whereSoort($value)
 * @method static Builder|\App\Product whereStatus($value)
 * @method static Builder|\App\Product whereUpdatedAt($value)
 * @method static Builder|\App\Product whereUserId($value)
 * @property string|null                                          $factuur
 * @property string|null                                          $kostenplaats
 * @property string|null                                          $referentie
 * @property-read User                                            $user
 * @property-read InfoProduct                                     $info
 * @method static Builder|Product whereFactuur($value)
 * @method static Builder|Product whereKostenplaats($value)
 * @method static Builder|Product whereReferentie($value)
 * @method static Builder|Product byUser( User $user)
 * @property-read Collection|Hour[] $hours
 * @method static Builder|Product filter($input = array(), $filter = null)
 * @method static Builder|Product paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|Product simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|Product whereBeginsWith($column, $value, $boolean = 'and')
 * @method static Builder|Product whereEndsWith($column, $value, $boolean = 'and')
 * @method static Builder|Product whereLike($column, $value, $boolean = 'and')
 * @property int|null                                             $updated_by
 * @method static Builder|Product finished()
 * @method static Builder|Product inProgress()
 * @method static Builder|Product requested()
 * @method static Builder|Product whereUpdatedBy($value)
 * @property-read int|null $hours_count
 * @property-read \App\Models\Order $order
 */
class Product extends Model
{
    use Filterable;

    protected $fillable = [
        'name',
        'description',
        'options',
        'format',
        'attachment',
        'factuur',
        'kostenplaats',
        'referentie',
        'user_id',
        'soort',
        'status',
        'deadline',
        'created_at',
        'updated_at',
        'updated_by',
    ];

    /*
     * Scopes
     */

    /**
     * Query scope to fetch products per user.
     *
     * @param Builder $query the query.
     * @param User    $user  the included user.
     *
     * @return Builder
     */
    public function scopeByUser(Builder $query, User $user): Builder
    {
        $userIds = $user->bedrijf->first()->users()->pluck('id');
        return $query->where('user_id', 'IN', $userIds);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeFinished(Builder $query): Builder
    {
        return $query->where('status', '=', 'afgerond');
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('status', '=', 'opgepakt');
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeRequested(Builder $query): Builder
    {
        return $query->where('status', '=', 'aangevraagd');
    }

    /*
     * Relationships
     */

    /**
     * Creates an Eloquent relation.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->order->user();
    }

    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class);
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'orderable');
    }

    public function info()
    {
        return $this->morphOne(InfoProduct::class, 'infoable');
    }
}
