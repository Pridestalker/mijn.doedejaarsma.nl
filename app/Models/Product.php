<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @mixin \Eloquent
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSoort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUserId($value)
 * @property string|null $factuur
 * @property string|null $kostenplaats
 * @property string|null $referentie
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFactuur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereKostenplaats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereReferentie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product byUser(\App\User $user)
 */
class Product extends Model
{
    //
    
    protected $fillable = array(
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
    );
    
    /*
     * Scopes
     */
    
    public function scopeByUser(Builder $query, User $user)
    {
        $userIds = $user->bedrijf->first()->users()->pluck('id');
        return $query->whereIn('user_id', $userIds);
    }
    
    /*
     * Relationships
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\User::class);
    }
}
