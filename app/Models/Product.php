<?php

namespace App\Models;

use App\User;
use Eloquent;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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
 * @property string|null $factuur
 * @property string|null $kostenplaats
 * @property string|null $referentie
 * @property-read User   $user
 * @method static Builder|Product whereFactuur($value)
 * @method static Builder|Product whereKostenplaats($value)
 * @method static Builder|Product whereReferentie($value)
 * @method static Builder|Product byUser( User $user)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hour[] $hours
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereLike($column, $value, $boolean = 'and')
 * @property int|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product finished()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product inProgress()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product requested()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedBy($value)
 */
class Product extends Model
{
    //
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
    public function scopeByUser(Builder $query, User $user)
    {
        $userIds = $user->bedrijf->first()->users()->pluck('id');
        return $query->where('user_id', 'IN', $userIds);
    }
    
    public function scopeFinished(Builder $query)
    {
        return $query->where('status', '=', 'afgerond');
    }
    
    public function scopeInProgress(Builder $query)
    {
        return $query->where('status', '=', 'opgepakt');
    }
    
    public function scopeRequested(Builder $query)
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
        return $this->belongsTo(User::class);
    }
    
    /**
     * Creates an Eloquent relation.
     *
     * @return HasMany
     */
    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class);
    }
}
