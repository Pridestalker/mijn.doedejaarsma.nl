<?php

namespace App\Models;

use App\ModelFilters\HoursFilter\DefaultFilter;
use App\User;
use Eloquent;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Hour
 *
 * @property int                             $id
 * @property int                             $product_id
 * @property int                             $user_id
 * @property string                          $remarks
 * @property float                           $hours
 * @property Carbon|null                     $created_at
 * @property Carbon|null                     $updated_at
 * @property-read Product                    $product
 * @property-read User                       $user
 * @method static Builder|Hour newModelQuery()
 * @method static Builder|Hour newQuery()
 * @method static Builder|Hour query()
 * @method static Builder|Hour whereCreatedAt($value)
 * @method static Builder|Hour whereHours($value)
 * @method static Builder|Hour whereId($value)
 * @method static Builder|Hour whereProductId($value)
 * @method static Builder|Hour whereRemarks($value)
 * @method static Builder|Hour whereUpdatedAt($value)
 * @method static Builder|Hour whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|Hour filter($input = array(), $filter = null)
 * @method static Builder|Hour paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|Hour simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|Hour whereBeginsWith($column, $value, $boolean = 'and')
 * @method static Builder|Hour whereEndsWith($column, $value, $boolean = 'and')
 * @method static Builder|Hour whereLike($column, $value, $boolean = 'and')
 */
class Hour extends Model
{
    use Filterable;
    
    protected $fillable = [
        'user_id',
        'remarks',
        'product_id',
        'hours',
        'created_at'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * @return string
     */
    public function modelFilter(): string
    {
    	return $this->provideFilter(DefaultFilter::class);
    }
}
