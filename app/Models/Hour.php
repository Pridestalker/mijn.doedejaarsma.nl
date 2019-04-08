<?php

namespace App\Models;

use App\ModelFilters\HoursFilter\DefaultFilter;
use App\User;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hour
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string $remarks
 * @property float $hours
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereLike($column, $value, $boolean = 'and')
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
    
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function modelFilter()
    {
    	return $this->provideFilter(DefaultFilter::class);
    }
}
