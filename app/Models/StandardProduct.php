<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
