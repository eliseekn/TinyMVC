<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Console\Database;

use Core\Database\Connection\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Execute MySQL queries.
 */
class Query extends Command
{
    protected static $defaultName = 'db:query';

    protected function configure(): void
    {
        $this->setDescription('Execute MySQL query and fetch results');
        $this->addArgument('query', InputArgument::REQUIRED, 'The query string to execute (inside "")');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stmt = Connection::getInstance()->executeQuery($input->getArgument('query'));
        $output->writeln('<info>[INFO] Query executed</info>');
        $output->writeln('');

        $result = $stmt->fetchAll();
        $rows = [];

        foreach ($result as $key => $value) {
            foreach ($value as $k => $v) {
                $rows[] = [$k, $v];
            }

            $rows[] = ['', ''];
        }

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);
        $table->setRows($rows);
        $table->render();

        return Command::SUCCESS;
    }
}
