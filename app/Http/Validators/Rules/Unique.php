<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace App\Http\Validators\Rules;

use Core\Database\Repository;
use Core\Http\Validator\RuleInterface;

class Unique implements RuleInterface
{
    public string $name = 'unique';

    public string $errorMessage = 'This {field} is already registered';

    public function rule(string $field, array $input, array $params, $value): bool
    {
        return ! (new Repository($params[0]))
            ->select('*')
            ->where($field, $value)
            ->exists();
    }
}
