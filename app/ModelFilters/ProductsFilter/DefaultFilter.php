<?php
namespace App\ModelFilters\ProductsFilter;

use App\Models\Hour;
use App\Models\Team;
use Auth;
use DB;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\Log;

class DefaultFilter extends ModelFilter
{
    protected $blacklist = ['team'];
    
    public function user($id)
    {
        return $this->where('user_id', $id);
    }
    
    public function name($name)
    {
        return $this->whereLike('name', $name);
    }
    
    public function setup(): void
    {
        if (Auth::user()->isA('customer')) {
            if ($_REQUEST['team'] && $_REQUEST['team'] === 'true') {
                $this->whitelistMethod('team');
            } else {
                $this->where('user_id', '=', Auth::user()->id);
            }
        }
    }
    
    public function status($status)
    {
        return $this->whereIn('status', $status);
    }
    
    public function team()
    {
        return $this->whereIn('user_id', Auth::user()->bedrijf->first()->users()->pluck('id'));
    }
    
    public function teamName($name)
    {
        $teams = Team::where('name', 'like', "%$name%")->get();
        $users = $teams->map(
            function (Team $team, $key) {
                return $team->users()->pluck('id')->toArray();
            }
        );
        
        if (!(sizeof($users->toArray()) >= 2)) {
            return $this;
        }
        
        return $this->whereIn('user_id', $users->toArray()[1]);
    }
    
    public function ordered($order)
    {
        if (is_array($order)) {
            foreach ($order as $o) {
                $this->orderBy($o, $_REQUEST['order']?? 'ASC');
            }
        } else {
            $this->orderBy($order, $_REQUEST['order']?? 'ASC');
        }
        
        return $this;
    }
    
    public function monthCreated($month)
    {
        return $this->whereMonth(
            'created_at',
            str_pad($month, 2, '0', STR_PAD_LEFT)
        );
    }
    
    public function hoursMonthCreated($month)
    {
        $hours = Hour::whereMonth(
            'created_at',
            str_pad($month, 2, '0', STR_PAD_LEFT)
        )
                     ->select('product_id')
                     ->distinct()->get();
        
        return $this->whereIn('id' , $hours->pluck('product_id')->toArray());
    }
    
    public function hoursYearCreated($year)
    {
        $hours = Hour::whereYear(
            'created_at',
            str_pad($year, 2, '0', STR_PAD_LEFT)
        )
                     ->select('product_id')
                     ->distinct()->get();
    
        return $this->whereIn('id' , $hours->pluck('product_id')->toArray());
    }
}
