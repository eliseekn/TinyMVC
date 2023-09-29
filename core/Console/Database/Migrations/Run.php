<?php

/**
 * @copyright (2019 - 2023) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Console\Database\Migrations;

use Core\Database\Connection\Connection;
use Core\Support\Storage;
use Core\Database\Migration;
use Core\Database\QueryBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Run migrations tables
 */
class Run extends Command
{
    protected static $defaultName = 'migrations:run';

    protected function configure(): void
    {
        $this->setDescription('Run migrations tables');
        $this->addArgument('table', InputArgument::OPTIONAL|InputArgument::IS_ARRAY, 'The name of migrations tables (separated by space if many)');
        $this->addOption('seed', null, InputOption::VALUE_NONE, 'Insert all seeds');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tables = $input->getArgument('table');

        if (!Connection::getInstance()->tableExists('migrations')) {
            Migration::createTable('migrations')
                ->addPrimaryKey()
                ->addString('name')
                ->run();

            $output->writeln('<info>[INFO] Migrations tables have been created</info>');
        }

        if (empty($tables)) {
            $files = Storage::path(config('storage.migrations'))->getFiles();

            foreach ($files as $file) {
                $this->migrate($output, get_file_name($file));
            }
        }

        else {
            foreach ($tables as $table) {
                $this->migrate($output, $table);
            }
        }

        if ($input->getOption('seed')) {
            $this->getApplication()->find('db:seed')->run(new ArrayInput($tables), $output);
        }

        return Command::SUCCESS;
    }

    protected function migrate(OutputInterface $output, string $table): void
    {
        if ($this->isMigrated($table)) {
            $output->writeln('<comment>[WARNING] Table "' . $table . '" has already been migrated</>');
            return;
        }

        $migration = '\App\Database\Migrations\\' . $table;
        (new $migration())->create();
        
        QueryBuilder::table('migrations')
            ->insert(['name' => $table])
            ->execute();

        $output->writeln('<info>[INFO] Table "' . $table . '" has been migrated</info>');
    }

    protected function isMigrated(string $table): bool
    {
        if (!Connection::getInstance()->tableExists('migrations')) {
            return false;
        }

        return QueryBuilder::table('migrations')
            ->select('*')
            ->where('name', $table)
            ->exists();
    }
}
