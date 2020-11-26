<?php

namespace App\Database\Seeds;

use Framework\ORM\Seeder;
use PragmaRX\Countries\Package\Countries;

class CountrySeed
{     
    /**
     * name of table
     *
     * @var string
     */
    public static $table = 'countries';

    /**
     * insert row
     *
     * @return void
     */
    public static function insert(): void
    {
        foreach (Countries::all() as $country) {
            $country_name = $country['name_' . config('app.lang')];

            if (!is_null($country_name) && !empty($country_name)) {
                Seeder::add(static::$table, [
                    'name' => utf8_decode($country_name)
                ]);
            }
        }
    }
}