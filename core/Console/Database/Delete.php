<?php

/**
 * @copyright (2019 - 2024) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Console\Database;

use Core\Database\Connection\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Delete database 
 */
class Delete extends Command
{
    protected static $defaultName = 'db:delete';

    protected function configure(): void
    {
        $this->setDescription('Delete database');
        $this->addArgument('database', InputArgument::IS_ARRAY, 'The name of database (separated by space if many)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connection = Connection::getInstance();
        $databases = $input->getArgument('database');

        if (empty($databases)) {
            $db = config('app.env') !== 'test'
                ? config('database.name')
                : config('database.name') . config('tests.database.suffix') ;

            $databases = [$db];
        }

        foreach ($databases as $database) {
            if (!$connection->schemaExists($database)) {
                $output->writeln('<comment>[WARNING] Database "' . $database . '" does not exists</comment>');
            } else {
                $connection->deleteSchema($database);
                $output->writeln('<info>[INFO] Database "' . $database . '" has been deleted</info>');
            }
        }

        return Command::SUCCESS;
    }
}
