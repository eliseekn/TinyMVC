<?php

/**
 * @copyright 2021 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Console\Database;

use Core\Database\Connection;
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

    protected function configure()
    {
        $this->setDescription('Delete database');
        $this->addArgument('database', InputArgument::IS_ARRAY, 'The name of database (separated by space if many)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $databases = $input->getArgument('database');

        if (is_null($databases) || empty($databases)) {
            $databases = [config('database.name')];
        }

        foreach ($databases as $database) {
            if (!Connection::getInstance()->schemaExists($database)) {
                $output->writeln('<fg=yellow>Database "' . $database . '" does not exists</>');
            } else {
                Connection::getInstance()->deleteSchema($database);
                $output->writeln('<info>Database "' . $database . '" has been deleted</info>');
            }
        }

        return Command::SUCCESS;
    }
}
