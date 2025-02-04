<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Console\Make;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Create new model file.
 */
class Model extends Command
{
    protected static $defaultName = 'make:model';

    protected function configure(): void
    {
        $this->setDescription('Create new model');
        $this->addArgument('model', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The name of model (separated by space if many)');
        $this->addOption('migration', 'm', InputOption::VALUE_NONE, 'Create new migration');
        $this->addOption('controller', 'c', InputOption::VALUE_NONE, 'Create new controller');
        $this->addOption('factory', 'f', InputOption::VALUE_NONE, 'Create new factory');
        $this->addOption('seed', 's', InputOption::VALUE_NONE, 'Create new seed');
        $this->addOption('actions', 'a', InputOption::VALUE_NONE, 'Create new actions');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Specify namespace (base: App\Database\Models)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $models = $input->getArgument('model');

        foreach ($models as $model) {
            list($name, $class) = Maker::generateClass($model);

            if (! Maker::createModel($name, $input->getOption('namespace'))) {
                $output->writeln('<error>[ERROR] Failed to create model "' . Maker::fixPlural($class, true) . '"</error>');
            } else {
                $output->writeln('<info>[INFO] Model "' . Maker::fixPlural($class, true) . '" has been created</info>');

                if ($input->getOption('migration')) {
                    $this->getApplication()->find('make:migration')->run(new ArrayInput(['migration' => [$model]]), $output);
                }

                if ($input->getOption('controller')) {
                    $this->getApplication()->find('make:controller')->run(new ArrayInput([
                        'controller' => [$model],
                        '--namespace' => $input->getOption('namespace'),
                    ]), $output);
                }

                if ($input->getOption('factory')) {
                    $this->getApplication()->find('make:factory')->run(new ArrayInput(['factory' => [$model]]), $output);
                }

                if ($input->getOption('seed')) {
                    $this->getApplication()->find('make:seed')->run(new ArrayInput(['seed' => [$model]]), $output);
                }

                if ($input->getOption('actions')) {
                    $this->getApplication()->find('make:actions')->run(new ArrayInput([
                        'model' => [$model],
                        '--namespace' => $input->getOption('namespace'),
                    ]), $output);
                }
            }
        }

        return Command::SUCCESS;
    }
}
