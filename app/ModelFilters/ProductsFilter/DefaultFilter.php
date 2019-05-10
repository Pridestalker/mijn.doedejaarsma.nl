<?php
namespace App\ModelFilters\ProductsFilter;

use App\Models\Team;
use App\User;
use Auth;
use DB;
use EloquentFilter\ModelFilter;

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
    
    public function setup()
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
}
