<?php
namespace App\ModelFilters\ProductsFilter;

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
        if (\Auth::user()->isA('customer')) {
            if ($_REQUEST['team'] && $_REQUEST['team'] === 'true') {
                $this->whitelistMethod('team');
            } else {
                $this->where('user_id', '=', \Auth::user()->id);
            }
        }
    }
    
    public function status($status)
    {
        return $this->whereIn('status', $status);
    }
    
    public function team()
    {
        return $this->whereIn('user_id', \Auth::user()->bedrijf->first()->users()->pluck('id'));
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
