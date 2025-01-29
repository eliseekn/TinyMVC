<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Database\Factory;

use Core\Database\Model;

/**
 * Manage models factories.
 */
class Factory
{
    protected array $class;

    public function __construct(public string $model, int $count)
    {
        for ($i = 1; $i <= $count; $i++) {
            $this->class[] = new $model();
        }
    }

    public function data(): array
    {
        return [];
    }

    public function make(array $data = []): mixed
    {
        if (count($this->class) === 1) {
            $this->class[0]->set(array_merge($this->data(), $data));

            return $this->class[0];
        }

        return array_map(function ($model) use ($data) {
            $model->set(array_merge($this->data(), $data));

            return $model;
        }, $this->class);
    }

    public function create(array $data = []): Model|array|bool
    {
        $class = $this->make($data);

        if (! is_array($class)) {
            return $class->create($class->get());
        }

        return array_map(fn ($c) => $c->create($c->get()), $class);
    }
}
