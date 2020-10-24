<?php

/**
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

namespace Framework\Console;

use Framework\Support\Storage;

/**
 * Manage application stubs
 */
class Make
{
    /**
     * get stubs path
     *
     * @return Framework\Support\Storage
     */
    private static function stubsPath(): Storage
    {
        return Storage::path(config('storage.stubs'));
    }

    /**
     * parseCommands
     *
     * @param  array $options
     * @return void
     */
    public static function parseCommands(array $options): void
    {
        if (
            array_key_exists('controller', $options) &&
            !array_key_exists('namespace', $options) &&
            !array_key_exists('model', $options) &&
            !array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            !array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Controller.stub');
            $data = str_replace('NAMESPACE', 'App\Controllers', $data);
            $data = str_replace('CLASSNAME', $options['controller'], $data);

            if (!Storage::path(config('storage.controllers'))->writeFile($options['controller'] . '.php', $data)) {
                exit('[-] Failed to create controller file ' . $options['controller'] . '.php' . PHP_EOL);
            }
        }

        else if (
            array_key_exists('controller', $options) &&
            array_key_exists('namespace', $options) &&
            !array_key_exists('model', $options) &&
            !array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            !array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Controller.stub');
            $data = str_replace('NAMESPACE', 'App\Controllers\\' . $options['namespace'], $data);
            $data = str_replace('CLASSNAME', $options['controller'], $data);

            $path = Storage::path(config('storage.controllers'));

            if (!$path->isDir($options['namespace'])) {
                $path->createDir($options['namespace']);
            }

            if (!$path->add($options['namespace'] . DIRECTORY_SEPARATOR)->writeFile($options['controller'] . '.php', $data)) {
                exit('[-] Failed to create controller file ' . $options['controller'] . '.php' . PHP_EOL);
            }
        }

        else if (
            !array_key_exists('controller', $options) &&
            !array_key_exists('namespace', $options) &&
            array_key_exists('model', $options) &&
            !array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Model.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Models', $data);
            $data = str_replace('CLASSNAME', $options['model'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            if (!Storage::path(config('storage.models'))->writeFile($options['model'] . '.php', $data)) {
                exit('[-] Failed to create model file ' . $options['model'] . '.php' . PHP_EOL);
            }
        }

        else if (
            !array_key_exists('controller', $options) &&
            array_key_exists('namespace', $options) &&
            array_key_exists('model', $options) &&
            !array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Model.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Models\\' . $options['namespace'], $data);
            $data = str_replace('CLASSNAME', $options['model'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            $path = Storage::path(config('storage.models'));

            if (!$path->isDir($options['namespace'])) {
                $path->createDir($options['namespace']);
            }

            if (!$path->add($options['namespace'] . DIRECTORY_SEPARATOR)->writeFile($options['model'] . '.php', $data)) {
                exit('[-] Failed to create model file ' . $options['model'] . '.php' . PHP_EOL);
            }
        }

        else if (
            !array_key_exists('controller', $options) &&
            !array_key_exists('namespace', $options) &&
            !array_key_exists('model', $options) &&
            array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Migration.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Migrations', $data);
            $data = str_replace('CLASSNAME', $options['migration'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            if (!Storage::path(config('storage.migrations'))->writeFile($options['migration'] . '.php', $data)) {
                exit('[-] Failed to create migration file ' . $options['migration'] . '.php' . PHP_EOL);
            }
        }

        else if (
            !array_key_exists('controller', $options) &&
            !array_key_exists('namespace', $options) &&
            array_key_exists('model', $options) &&
            array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Migration.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Migrations', $data);
            $data = str_replace('CLASSNAME', $options['migration'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            if (!Storage::path(config('storage.migrations'))->writeFile($options['migration'] . '.php', $data)) {
                exit('[-] Failed to create migration file ' . $options['migration'] . '.php' . PHP_EOL);
            }

            //
            $data = self::stubsPath()->readFile('Model.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Models', $data);
            $data = str_replace('CLASSNAME', $options['model'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            if (!Storage::path(config('storage.models'))->writeFile($options['model'] . '.php', $data)) {
                exit('[-] Failed to create model file ' . $options['model'] . '.php' . PHP_EOL);
            }
        }

        else if (
            !array_key_exists('controller', $options) &&
            array_key_exists('namespace', $options) &&
            !array_key_exists('model', $options) &&
            array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Migration.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Migration\\' . $options['namespace'], $data);
            $data = str_replace('CLASSNAME', $options['migration'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            $path = Storage::path(config('storage.migrations'));

            if (!$path->isDir($options['namespace'])) {
                $path->createDir($options['namespace']);
            }

            if (!$path->add($options['namespace'] . DIRECTORY_SEPARATOR)->writeFile($options['migration'] . '.php', $data)) {
                exit('[-] Failed to create migration file ' . $options['migration'] . '.php' . PHP_EOL);
            }
        }

        else if (
            !array_key_exists('controller', $options) &&
            array_key_exists('namespace', $options) &&
            array_key_exists('model', $options) &&
            array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Migration.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Migration\\' . $options['namespace'], $data);
            $data = str_replace('CLASSNAME', $options['migration'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            $path = Storage::path(config('storage.migrations'));

            if (!$path->isDir($options['namespace'])) {
                $path->createDir($options['namespace']);
            }

            if (!$path->add($options['namespace'] . DIRECTORY_SEPARATOR)->writeFile($options['migration'] . '.php', $data)) {
                exit('[-] Failed to create migration file ' . $options['migration'] . '.php' . PHP_EOL);
            }

            //
            $data = self::stubsPath()->readFile('Model.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Models\\' . $options['namespace'], $data);
            $data = str_replace('CLASSNAME', $options['model'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            $path = Storage::path(config('storage.models'));

            if (!$path->isDir($options['namespace'])) {
                $path->createDir($options['namespace']);
            }

            if (!$path->add($options['namespace'] . DIRECTORY_SEPARATOR)->writeFile($options['model'] . '.php', $data)) {
                exit('[-] Failed to create model file ' . $options['model'] . '.php' . PHP_EOL);
            }
        }

        else if (
            !array_key_exists('controller', $options) &&
            !array_key_exists('namespace', $options) &&
            !array_key_exists('model', $options) &&
            !array_key_exists('migration', $options) &&
            array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Seed.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Seeds', $data);
            $data = str_replace('CLASSNAME', $options['seed'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            if (!Storage::path(config('storage.seeds'))->writeFile($options['seed'] . '.php', $data)) {
                exit('[-] Failed to create seed file ' . $options['seed'] . '.php' . PHP_EOL);
            }
        }

        else if (
            !array_key_exists('controller', $options) &&
            array_key_exists('namespace', $options) &&
            !array_key_exists('model', $options) &&
            !array_key_exists('migration', $options) &&
            array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('middleware', $options) &&
            array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Seed.stub');
            $data = str_replace('NAMESPACE', 'App\Database\Seeds\\' . $options['namespace'], $data);
            $data = str_replace('CLASSNAME', $options['seed'], $data);
            $data = str_replace('TABLENAME', $options['table'], $data);

            $path = Storage::path(config('storage.seeds'));

            if (!$path->isDir($options['namespace'])) {
                $path->createDir($options['namespace']);
            }

            if (!$path->add($options['namespace'] . DIRECTORY_SEPARATOR)->writeFile($options['seed'] . '.php', $data)) {
                exit('[-] Failed to create seed file ' . $options['seed'] . '.php' . PHP_EOL);
            }
        }

        else if (
            array_key_exists('request', $options) &&
            !array_key_exists('controller', $options) &&
            !array_key_exists('namespace', $options) &&
            !array_key_exists('model', $options) &&
            !array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('middleware', $options) &&
            !array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Request.stub');
            $data = str_replace('NAMESPACE', 'App\Requests', $data);
            $data = str_replace('CLASSNAME', $options['request'], $data);

            if (!Storage::path(config('storage.requests'))->writeFile($options['request'] . '.php', $data)) {
                exit('[-] Failed to create request file ' . $options['request'] . '.php' . PHP_EOL);
            }
        }

        else if (
            array_key_exists('middleware', $options) &&
            !array_key_exists('controller', $options) &&
            !array_key_exists('namespace', $options) &&
            !array_key_exists('model', $options) &&
            !array_key_exists('migration', $options) &&
            !array_key_exists('seed', $options) &&
            !array_key_exists('request', $options) &&
            !array_key_exists('table', $options)
        ) {
            $data = self::stubsPath()->readFile('Middleware.stub');
            $data = str_replace('NAMESPACE', 'App\Middlewares', $data);
            $data = str_replace('CLASSNAME', $options['middleware'], $data);

            if (!Storage::path(config('storage.middlewares'))->writeFile($options['middleware'] . '.php', $data)) {
                exit('[-] Failed to create middleware file ' . $options['middleware'] . '.php' . PHP_EOL);
            }
        }
        
        else if (array_key_exists('help', $options)) {
            $help_message = '[+] Commands list:' . PHP_EOL;
            $help_message .= PHP_EOL;
            $help_message .= '      --controller=UsersController                            Create UsersController file' . PHP_EOL;
            $help_message .= '      --controller=UsersController --namespace=Users          Create UsersController file in app\Controllers\Users folder' . PHP_EOL;
            $help_message .= PHP_EOL;
            $help_message .= '      --model=UsersModel --table=users                        Create UsersModel file using table users' . PHP_EOL;
            $help_message .= '      --model=UsersModel --table=users --namespace=Users      Create UsersModel file in app\Database\Models\Users folder' . PHP_EOL;
            $help_message .= PHP_EOL;
            $help_message .= '      --migration=UsersTable --table=users                    Create UsersTable file using table users' . PHP_EOL;
            $help_message .= '      --migration=UsersTable --table=users --namespace=Users  Create UsersTable file in app\Database\Migrations\Users folder' . PHP_EOL;
            $help_message .= PHP_EOL;
            $help_message .= '      --seed=UserSeed --table=users                           Create UserSeed file using table users' . PHP_EOL;
            $help_message .= '      --seed=UserSeed --table=users --namespace=Users         Create UserSeed file in app\Database\Seeds\Users folder' . PHP_EOL;
            $help_message .= PHP_EOL;
            $help_message .= '      --request=AuthRequest                                   Create AuthRequest file' . PHP_EOL;
            $help_message .= PHP_EOL;
            $help_message .= '      --middleware=AuthPolicy                                 Create AuthPolicy file' . PHP_EOL;
            
            exit($help_message);
        } 
        
        else {
            exit('[-] Invalid command line arguments, print "--help" for commands list' . PHP_EOL);
        }

        exit('[+] Operations done successfully.' . PHP_EOL);
    }
}