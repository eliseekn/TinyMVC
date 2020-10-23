<?php

/**
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

namespace Framework\Support;

/**
 * Manage session
 */
class Session
{    
    /**
     * create
     *
     * @param  string $name
     * @param  mixed $data
     * @return void
     */
    public static function create(string $name, $data): void
    {
        create_session($name, $data);
    }
    
    /**
     * get
     *
     * @param  string $name
     * @return mixed
     */
    public static function get(string $name)
    {
        return get_session($name);
    }
    
    /**
     * has
     *
     * @param  string $name
     * @return bool
     */
    public static function has(string $name): bool
    {
        return session_has($name);
    }
    
    /**
     * close
     *
     * @param  string $name
     * @return void
     */
    public static function close(string $name): void
    {
        close_session($name);
    }
    
    /**
     * setUser
     *
     * @param  mixed $data
     * @return void
     */
    public static function setUser($data): void
    {
        self::create(config('app.name') . '_user', $data);
    }
    
    /**
     * getUser
     *
     * @return mixed
     */
    public static function getUser()
    {
        return self::get(config('app.name') . '_user');
    }
    
    /**
     * hasUser
     *
     * @return bool
     */
    public static function hasUser(): bool
    {
        return self::has(config('app.name') . '_user');
    }
    
    /**
     * deleteUser
     *
     * @return void
     */
    public static function deleteUser(): void
    {
        self::close(config('app.name') . '_user');
    }
}