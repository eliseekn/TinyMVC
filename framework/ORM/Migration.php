<?php

/**
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

namespace Framework\ORM;

/**
 * Manage database migrations
 */
class Migration
{
    /**
	 * @var \Framework\ORM\Builder
	 */
    protected static $query;
    
    /**
     * generate CREATE TABLE query 
     *
     * @param  string $name
     * @return \Framework\ORM\Migration
     */
    public static function table(string $name): self
    {
        self::$query = Builder::table($name);
        return new self();
    }

    /**
     * add column of type integer
     *
     * @param  string $name
     * @param  int $length
     * @return \Framework\ORM\Migration
     */
    public function addInt(string $name, int $length = 11): self 
    {
        self::$query->column($name, "INT($length)");
        return $this;
    }

    /**
     * add column of type small integer
     *
     * @param  string $name
     * @param  int $length
     * @return \Framework\ORM\Migration
     */
    public function addSmallInt(string $name, int $length = 6): self 
    {
        self::$query->column($name, "MALLINT($length)");
        return $this;
    }

    /**
     * add column of type big integer
     *
     * @param  string $name
     * @param  int $length
     * @return \Framework\ORM\Migration
     */
    public function addBigInt(string $name, int $length = 20): self 
    {
        self::$query->column($name, "BIGINT($length)");
        return $this;
    }

    /**
     * add column of type char
     *
     * @param  string $name
     * @return \Framework\ORM\Migration
     */
    public function addChar(string $name): self 
    {
        self::$query->column($name, "CHAR(1)");
        return $this;
    }

    /**
     * add column of type string
     *
     * @param  string $name
     * @param  int $length
     * @return \Framework\ORM\Migration
     */
    public function addString(string $name, int $length = 255): self 
    {
        self::$query->column($name, "VARCHAR($length)");
        return $this;
    }

    /**
     * add column of type text
     *
     * @param  string $name
     * @return \Framework\ORM\Migration
     */
    public function addText(string $name): self 
    {
        self::$query->column($name, "TEXT");
        return $this;
    }

    /**
     * add column of type longtext
     *
     * @param  string $name
     * @return \Framework\ORM\Migration
     */
    public function addLongText(string $name): self 
    {
        self::$query->column($name, "LONGTEXT");
        return $this;
    }

    /**
     * add column of type timestamp
     *
     * @param  string $name
     * @return \Framework\ORM\Migration
     */
    public function addTimestamp(string $name): self 
    {
        self::$query->column($name, "TIMESTAMP");
        return $this;
    }

    /**
     * add column of type boolean
     *
     * @param  string $name
     * @return \Framework\ORM\Migration
     */
    public function addBoolean(string $name): self 
    {
        self::$query->column($name, "TINYINT(1)");
        return $this;
    }
    
    /**
     * add primary key and auto increment attributes
     *
     * @return \Framework\ORM\Migration
     */
    public function primaryKey(): self
    {
        self::$query->primaryKey();
        return $this;
    }
    
    /**
     * add null attribute
     * 
     * @return \Framework\ORM\Migration
     */
    public function null(): self
    {
        self::$query->null();
        return $this;
    }

    /**
     * add unique attribute
     *
     * @return \Framework\ORM\Migration
     */
    public function unique(): self
    {
        self::$query->unique();
        return $this;
    }

    /**
     * add default attribute
     *
     * @param  mixed $default
     * @return \Framework\ORM\Migration
     */
    public function default($default) : self
    {
        self::$query->default($default);
        return $this;
    }
    
    /**
     * execute
     *
     * @return void
     */
    public static function execute(): void
    {
        list($query, $args) = self::$query->get();
        Database::getInstance()->executeQuery($query, $args);
    }
    
    /**
     * create new table
     *
     * @return void
     */
    public function create(): void
    {
        self::$query->create();
        self::execute();
    }

    /**
     * drop table if exists
     *
     * @param  string $table
     * @return void
     */
    public static function drop(string $table): void
    {
        self::$query->drop($table);
        self::execute();
    }
}
