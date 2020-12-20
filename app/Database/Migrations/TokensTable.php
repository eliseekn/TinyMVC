<?php

namespace App\Database\Migrations;

use Framework\Database\Migration;

class TokensTable
{         
    /**
     * name of table
     *
     * @var string
     */
    public static $table = 'tokens';

    /**
     * create table
     *
     * @return void
     */
    public static function migrate(): void
    {
        Migration::table(self::$table)
            ->addBigInt('id')->primaryKey()
            ->addString('email')->unique()
            ->addString('token')->unique()
            ->addTimestamp('expires')->null()
            ->create();
    }
    
    /**
     * drop table
     *
     * @return void
     */
    public static function delete(): void
    {
        Migration::drop(self::$table);
    }
    
    /**
     * reset table
     *
     * @return void
     */
    public static function reset(): void
    {
        self::delete();
        self::migrate();
    }
}
