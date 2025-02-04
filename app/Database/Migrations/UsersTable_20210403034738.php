<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Database\Migrations;

use App\Enums\UserRole;
use Core\Database\Migration;

class UsersTable_20210403034738
{
    public function create(): void
    {
        Migration::createTable('users')
            ->addPrimaryKey()
            ->addString('name')
            ->addString('email')->unique()
            ->addString('password')
            ->addDateTime('email_verified_at')->nullable()
            ->addString('role')->default(UserRole::USER)
            ->addTimestamps()
            ->run();
    }

    public function drop(): void
    {
        Migration::dropTable('users');
    }
}
