<?php
namespace App\ModelFilters\HoursFilter;

use EloquentFilter\ModelFilter;

class DefaultFilter extends ModelFilter
{
    /**
     * Filter on either user and user_id
     *
     * @param integer $id The id to look for
     *
     * @return DefaultFilter
     */
    public function user($id)
    {
        return $this->where('user_id', $id);
    }
    
    /**
     * Filter on either product or product_id
     *
     * @param integer $id The id to look for
     *
     * @return DefaultFilter
     */
    public function product($id)
    {
        return $this->where('product_id', $id);
    }
    
    /**
     * Filter on a minimum hour
     *
     * @param integer $hours The hours to look for
     *
     * @return DefaultFilter
     */
    public function minHours($hours)
    {
        return $this->where('hours', '>=', $hours);
    }
    
    /**
     * Filter on a maximum hour
     *
     * @param integer $hours The hours to look for
     *
     * @return DefaultFilter
     */
    public function maxHours($hours)
    {
        return $this->where('hours', '<', $hours);
    }
    
    /**
     * Filter on a specific month.
     *
     * @param string $month The month to filter on.
     *
     * @return DefaultFilter|\Illuminate\Database\Query\Builder
     */
    public function month($month)
    {
        return $this->whereMonth(
            'created_at',
            str_pad($month, 2, '0', STR_PAD_LEFT)
        );
    }
    
    /**
     * Filter on a specific year.
     *
     * @param string $year The year to filter on
     *
     * @return DefaultFilter|\Illuminate\Database\Query\Builder
     */
    public function year($year)
    {
        return $this->whereYear('created_at', $year);
    }
    
    /**
     * Filter on a specific day.
     *
     * @param string $day The day to filter on.
     *
     * @return DefaultFilter|\Illuminate\Database\Query\Builder
     */
    public function day($day)
    {
        return $this->whereDay(
            'created_at',
            str_pad($day, 2, '0', STR_PAD_LEFT)
        );
    }
    
    
}
