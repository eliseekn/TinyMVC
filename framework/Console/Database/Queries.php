<?php

/**
 * @copyright 2021 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Framework\Console\Database;

use Framework\Database\Database;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Execute database queries 
 */
class Queries extends Command
{
    protected static $defaultName = 'db:query';

    protected function configure()
    {
        $this->setDescription('Execute MySQL queries and fetch results');
        $this->setHelp('This command allows you to execute MySQL queries');
        $this->addArgument('query', InputArgument::REQUIRED, 'The query string to execute (inside "")');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stmt = Database::connection()->query($input->getArgument('query'));
        $result = $stmt->fetchAll();
        $rows = [];

        foreach ($result as $key => $value) {
            foreach ($value as $k => $v) {
                $rows[] = [$k, $v];
            }
        }

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);
        $table->setRows($rows);
        $table->render();

        return Command::SUCCESS;
    }
}
