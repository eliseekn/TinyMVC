<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Database\Connection;

use PDO;
use PDOException;
use PDOStatement;

class MySQLConnection implements ConnectionInterface
{
    protected PDO $pdo;

    /**
     * @throws PDOException
     */
    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . config('database.mysql.host') . ';port=' . config('database.mysql.port'), config('database.mysql.username'), config('database.mysql.password'));
            $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES ' . config('database.mysql.charset') . ' COLLATE ' . config('database.mysql.collation'));
            $this->pdo->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, true);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    private function getDB(): string
    {
        return config('app.env') === 'test'
            ? config('database.name') . config('tests.database.suffix')
            : config('database.name');
    }

    /**
     * @throws PDOException
     */
    public function executeStatement(string $query): false|int
    {
        try {
            return $this->pdo->exec($query);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @throws PDOException
     */
    public function executeQuery(string $query, ?array $args = null): false|PDOStatement
    {

        try {
            $stmt = $this->pdo->prepare(trim($query));
            $stmt->execute($args);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode(), $e->getPrevious());
        }

        return $stmt;
    }

    public function schemaExists(string $name): bool
    {
        $stmt = $this->executeQuery('
            SELECT schema_name FROM information_schema.schemata WHERE schema_name = "' . $name . '"
        ');

        return $stmt->fetch() !== false;
    }

    public function tableExists(string $name): bool
    {
        $stmt = $this->executeQuery('
            SELECT * FROM information_schema.tables WHERE table_schema = "' . $this->getDB() . '" 
            AND table_name = "' . $name . '" LIMIT 1
        ');

        return $stmt->fetch() !== false;
    }

    public function createSchema(string $name): void
    {
        $this->executeStatement(
            '
            CREATE DATABASE ' . $name . ' CHARACTER SET ' . config('database.mysql.charset') .
            ' COLLATE ' . config('database.mysql.collation')
        );
    }

    public function deleteSchema(string $name): void
    {
        $this->executeStatement("DROP DATABASE IF EXISTS $name");
    }
}
