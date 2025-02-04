<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

/*
 * Console commands
 */

return [
    'core' => [
        new Core\Console\Database\Create(),
        new Core\Console\Database\Delete(),
        new Core\Console\Database\Show(),
        new Core\Console\Database\Query(),
        new Core\Console\Database\Migrations\Delete(),
        new Core\Console\Database\Migrations\Status(),
        new Core\Console\Database\Migrations\Run(),
        new Core\Console\Database\Migrations\Reset(),
        new Core\Console\Database\Seed(),

        new Core\Console\Make\Migration(),
        new Core\Console\Make\Model(),
        new Core\Console\Make\Controller(),
        new Core\Console\Make\Validator(),
        new Core\Console\Make\Rule(),
        new Core\Console\Make\Seeder(),
        new Core\Console\Make\Factory(),
        new Core\Console\Make\View(),
        new Core\Console\Make\Mail(),
        new Core\Console\Make\Middleware(),
        new Core\Console\Make\Console(),
        new Core\Console\Make\Password(),
        new Core\Console\Make\Helper(),
        new Core\Console\Make\Test(),
        new Core\Console\Make\UseCase(),
        new Core\Console\Make\Exception(),
        new Core\Console\Make\Event(),
        new Core\Console\Make\Listener(),

        new Core\Console\App\Setup(),
        new Core\Console\App\EncryptionKey(),
        new Core\Console\App\Environnement(),

        new Core\Console\ClearTwigCache(),
        new Core\Console\Server(),
        new Core\Console\Test(),
        new Core\Console\ClearLogs(),
        new Core\Console\Routes(),
        new Core\Console\Shell(),
    ],

    /*
     * Write your customs console commands here
     */
    'app' => [
        //
    ],
];
