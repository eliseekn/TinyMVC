<?php

namespace App\Database\Seeds;

use Framework\ORM\Seeder;
use Framework\Support\Encryption;

class UserSeed
{     
    /**
     * name of table
     *
     * @var string
     */
    protected static $table = 'users';

    /**
     * insert row
     *
     * @return void
     */
    public static function insert(): void
    {
        Seeder::add(self::$table, [
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Encryption::hash('admin'),
            'role' => 'administrator',
            'active' => 1
        ]);

        Seeder::add('sub_users', ['parent_id' => 1]);
    }
}
