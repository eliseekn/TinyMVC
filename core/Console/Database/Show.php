<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Console\Database;

use Core\Database\Connection\Connection;
use Core\Support\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Display list of databases.
 */
class Show extends Command
{
    protected static $defaultName = 'db:show';

    protected function configure(): void
    {
        $this->setDescription('Display list of databases');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = [];

        $driver = config('app.env') === 'test'
            ? config('tests.database.driver')
            : config('database.driver');

        if ($driver === 'mysql') {
            $databases = Connection::getInstance()->executeQuery('SHOW DATABASES')->fetchAll();

            foreach ($databases as $db) {
                $rows[] = [$db->Database];
            }
        } else {
            $databases = Storage::path(config('storage.sqlite'))->getFiles();

            foreach ($databases as $db) {
                $rows[] = [basename($db)];
            }
        }

        $table = new Table($output);
        $table->setHeaders(['Schemas']);
        $table->setRows($rows);
        $table->render();

        return Command::SUCCESS;
    }
}
