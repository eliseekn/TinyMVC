<?php

/**
 * @copyright (2019 - 2023) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Database;

use Faker\Factory as FakerFactory;
use Faker\Generator;

/**
 * Manage models factories
 */
class Factory
{
    protected static $model;
    protected array|Model $class;
    public Generator $faker;

    public function __construct(int $count)
    {
        $this->faker = FakerFactory::create(config('app.lang'));

        if ($count === 1) {
            $this->class = new static::$model();
        } else {
            for ($i = 1; $i <= $count; $i++) {
                $this->class[] = new static::$model();
            }
        }
    }

    public function data(): array
    {
        return [];
    }

    public function make(array $data = []): mixed
    {
        if (!is_array($this->class)) {
            $this->class->fill(array_merge($this->data(), $data));
            return $this->class;
        }

        return array_map(function ($model) use ($data) {
            $model->fill(array_merge($this->data(), $data));
            return $model;
        }, $this->class);
    }

    public function create(array $data = []): Model|array|bool
    {
        $class = $this->make($data);

        if (!is_array($class)) {
            return $class->save();
        }

        return array_map(function ($c) {
            $c->save();
            return $c;
        }, $class);
    }
}
