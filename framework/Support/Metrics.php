<?php

/**
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

namespace Framework\Support;

use Framework\ORM\Builder;

/**
 * Metrics generator
 */
class Metrics
{
    /**
     * @var string
     */
    private $table;
    
    /**
     * __construct
     *
     * @param  string $table
     * @return void
     */
    public function __construct(string $table)
    {
        $this->table = $table;
    }
    
    /**
     * get items value according to trends
     *
     * @param  string $value
     * @param  string $column
     * @param  string $trends
     * @return mixed
     * @link   https://www.tutsmake.com/mysql-get-data-of-current-date-week-month-year/
     */
    private function getTrends(string $value, string $column, string $trends)
    {
        switch ($trends) {
            case 'days':
                return Builder::select($value . '(' . $column . ') AS value')
                        ->from($this->table)
                        ->where('DATE(created_at)', '=', date('Y-m-d'))
                        ->execute()
                        ->fetchAll();


            case 'weeks':
                return Builder::select(
                        $value . '(' . $column . ') AS value',
                        'DAYNAME(created_at) AS day'
                    )
                    ->from($this->table)
                    ->where('DATE(created_at)', '>', date('Y-m-d', strtotime('-7 days')))
                    ->and('MONTH(created_at)', '=', date('m'))
                    ->and('YEAR(created_at)', '=', date('Y'))
                    ->groupBy('DAYNAME(created_at)')
                    ->orderBy('DAYNAME(created_at)', 'ASC')
                    ->execute()
                    ->fetchAll();

            case 'months':
                return Builder::select(
                        $value . '(' . $column . ') AS value',
                        'MONTHNAME(created_at) AS month'
                    )
                    ->from($this->table)
                    ->where('YEAR(created_at)', '=', date('Y'))
                    ->groupBy('MONTHNAME(created_at)')
                    ->orderBy('MONTHNAME(created_at)', 'ASC')
                    ->execute()
                    ->fetchAll();
            
            case 'years':
                return Builder::select(
                            $value . '(' . $column . ') AS value',
                            'YEAR(created_at) AS year'
                        )
                        ->from($this->table)
                        ->groupBy('YEAR(created_at)')
                        ->orderBy('YEAR(created_at)', 'ASC')
                        ->execute()
                        ->fetchAll();
        }
    }
    
    /**
     * get items count
     *
     * @param  string $column
     * @param  string|null $trends
     * @return mixed
     */
    public function getCount(string $column, ?string $trends = null)
    {
        if (is_null($trends)) {
            return Builder::select('COUNT(' . $column . ')')
                ->from($this->table)
                ->execute()
                ->fetchAll();
        } else {
            return $this->getTrends('COUNT' , $column, $trends);
        }
    }
    
    /**
     * get items sum
     *
     * @param  string $column
     * @param  string|null $trends
     * @return mixed
     */
    public function getSum(string $column, ?string $trends = null)
    {
        if (is_null($trends)) {
            return Builder::select('SUM(' . $column . ')')
                ->from($this->table)
                ->execute()
                ->fetchAll();
        } else {
            return $this->getTrends('SUM' , $column, $trends);
        }
    }
    
    /**
     * get items average
     *
     * @param  string $column
     * @param  string|null $trends
     * @return mixed
     */
    public function getAverage(string $column, ?string $trends = null)
    {
        if (is_null($trends)) {
            return Builder::select('AVG(' . $column . ')')
                ->from($this->table)
                ->execute()
                ->fetchAll();
        } else {
            return $this->getTrends('AVG' , $column, $trends);
        }
    }
    
    /**
     * get minimum item
     *
     * @param  string $column
     * @param  string|null $trends
     * @return mixed
     */
    public function getMin(string $column, ?string $trends = null)
    {
        if (is_null($trends)) {
            return Builder::select('MIN(' . $column . ')')
                ->from($this->table)
                ->execute()
                ->fetchAll();
        } else {
            return $this->getTrends('MIN' , $column, $trends);
        }
    }
    
    /**
     * get miaxmum item
     *
     * @param  string $column
     * @param  string|null $trends
     * @return mixed
     */
    public function getMax(string $column, ?string $trends = null)
    {
        if (is_null($trends)) {
            return Builder::select('MAX(' . $column . ')')
                ->from($this->table)
                ->execute()
                ->fetchAll();
        } else {
            return $this->getTrends('MAX' , $column, $trends);
        }
    
    }
}
