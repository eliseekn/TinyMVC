<?php

/**
 * @copyright 2021 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Database;

use Carbon\Carbon;

/**
 * Database query builder
 */
class QueryBuilder
{
	protected static $query = '';
    protected static $args = [];
    protected static $table;
    
    /**
     * Set table name
     */
    public static function table(string $name): self
    {
        static::$table = config('database.table_prefix')  . $name;
        return new self();
    }

    public static function createTable(string $name): self
    {
        self::$query = "CREATE TABLE " . config('database.table_prefix') . "$name (";
        return new self();
	}
	
	public static function dropTable(string $table): self
	{
		self::$query = "DROP TABLE IF EXISTS " . config('database.table_prefix') . $table;
		return new self();
	}
    
    public static function alter(string $table): self
    {
        self::$query = "ALTER TABLE " . config('database.table_prefix') . $table;
		return new self();
    }
	
	public static function dropForeign(string $table, string $key): self
	{
        self::alter($table);
        self::$query .= " DROP FOREIGN KEY $key";
		return new self();
	}
    
    public static function addColumn(string $table): self
    {
        self::alter($table);
        self::$query .= " ADD COLUMN ";
        return new self();
    }
    
    public static function renameColumn(string $table, string $old, string $new): self
    {
        self::alter($table);
        self::$query .= " RENAME COLUMN $old TO $new";
        return new self();
    }
    
    public static function updateColumn(string $table, string $column): self
    {
        self::alter($table);
        self::$query .= " CHANGE $column ";
        return new self();
    }
    
    public static function deleteColumn(string $table, string $column): self
    {
        self::alter($table);
        self::$query .= " DROP COLUMN $column";
        return new self();
    }
    
    public static function tableExists(string $table)
    {
        return self::setQuery('SELECT * FROM information_schema.tables WHERE table_schema = "' . config('database.name') .'" 
            AND table_name = "' . $table . '" LIMIT 1')->exists();
    }
    
    /**
     * Check if database exists
     */
    public static function schemaExists(string $db)
    {
        return self::setQuery('SELECT schema_name FROM information_schema.schemata WHERE schema_name = "' . $db .'"')->exists();
    }

	public function select(string ...$columns): self
	{
		self::$query = 'SELECT ';

		foreach ($columns as $column) {
			self::$query .= "$column, ";
		}

		self::$query = rtrim(self::$query, ', ');
        self::$query .= ' FROM ' . static::$table;

		return $this;
	}
    
    public function selectRaw(string $query, array $args = []): self
    {
        self::$query = 'SELECT ' . $query;
        self::$args = array_merge(self::$args, $args);
        self::$query .= ' FROM ' . static::$table;

        return $this;
    }

	public function selectWhere(string $column, $operator = null, $value = null): self
	{
        return $this->select('*')->where($column, $operator, $value);
	}

	public function insert(array $items): self
	{
		self::$query = "INSERT INTO " . static::$table . " (";

		foreach ($items as $key => $value) {
			self::$query .= "$key, ";
		}

		self::$query = rtrim(self::$query, ', ');
		self::$query .= ') VALUES (';

		foreach ($items as $key => $value) {
			self::$query .= '?, ';
			self::$args[] = $value;
		}

		self::$query = rtrim(self::$query, ', ');
		self::$query .= ')';

		return $this;
	}

	public function update(array $items): self
	{
		self::$query = "UPDATE " . static::$table . " SET ";

		if (config('database.timestamps')) {
            $items = array_merge($items, [
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        }

		foreach ($items as $key => $value) {
			self::$query .= "$key = ?, ";
			self::$args[] = $value;
		}

		self::$query = rtrim(self::$query, ', ');
		return $this;
	}

	public function delete(): self
	{
		self::$query = "DELETE FROM " . static::$table;
		return $this;
	}

	public function deleteWhere(string $column, $operator = null, $value = null): self
	{
        return $this->delete()->where($column, $operator, $value);
	}
    
    /**
     * Add after attribute
     */
    public function after(string $column): self
    {
        self::$query .= " AFTER $column";
        return $this;
    }
    
    /**
     * Add first attribute
     */
    public function first(): self
    {
        self::$query .= " FIRST";
        return $this;
    }
		
	public function column(string $name, string $type): self
	{
		self::$query .= "$name $type NOT NULL, ";
		return $this;
	}
    
    public function autoIncrement(): self
    {
        self::$query = rtrim(self::$query, ', ');
        self::$query .= ' AUTO_INCREMENT, ';
        return $this;
    }
    
    public function primaryKey(): self
    {
        self::$query = rtrim(self::$query, ', ');
        self::$query .= ' PRIMARY KEY, ';
        return $this;
    }
    
    public function nullable(): self
    {
        self::$query = str_replace('NOT NULL, ', 'NULL, ', self::$query);
        return $this;
    }

    public function unique(): self
    {
        self::$query = rtrim(self::$query, ', ');
        self::$query .= ' UNIQUE, ';
        return $this;
    }

    public function default($default): self
    {
        self::$query = rtrim(self::$query, ', ');
        self::$query .= " DEFAULT '$default', ";
        return $this;
	}
		
	public function foreignKey(string $name, string $column): self
	{
		self::$query .= " CONSTRAINT $name FOREIGN KEY ($column)";
        return $this;
	}
	
	public function references(string $table, string $column): self
	{
		self::$query .= " REFERENCES " . config('database.table_prefix') . "$table($column)";
        return $this;
	}
	
	public function onUpdateCascade(): self
	{
        self::$query = rtrim(self::$query, ', ');
		self::$query .= " ON UPDATE CASCADE, ";
        return $this;
	}
	
	public function onDeleteCascade(): self
	{
        self::$query = rtrim(self::$query, ', ');
		self::$query .= " ON DELETE CASCADE, ";
        return $this;
	}
	
	public function onUpdateSetNull(): self
	{
		self::$query .= " ON UPDATE SET NULL, ";
        return $this;
	}
	
	public function onDeleteSetNull(): self
	{
		self::$query .= " ON DELETE SET NULL, ";
        return $this;
	}
    
    /**
     * Create migration table
     */
    public function migrate()
    {
        if (config('database.timestamps')) {
            self::$query .= " created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";
        }

        if (self::$query[-1] !== ')') {
            self::$query .= ')';
        }

        self::$query .= " ENGINE='" . config('database.engine') . "'";

		$this->execute();
    }

	public function where(string $column, $operator = null, $value = null): self
	{
        if (!is_null($operator) && is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

		self::$query .= " WHERE $column $operator ? ";
		self::$args[] = $value;
		return $this;
	}
        
    public function whereRaw(string $query, array $args = []): self
    {
        return $this->rawQuery(' WHERE ' . $query, $args);
    }
        
    public function andRaw(string $query, array $args = []): self
    {
        return $this->rawQuery(' AND ' . $query, $args);
    }
        
    public function orRaw(string $query, array $args = []): self
    {
        return $this->rawQuery(' OR ' . $query, $args);
    }

	public function whereNot(string $column, $operator = null, $value = null): self
	{
        if (!is_null($operator) && is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

		self::$query .= " WHERE NOT $column $operator ? ";
		self::$args[] = $value;
		return $this;
	}

	public function whereColumn(string $column): self
	{
		self::$query .= " WHERE $column ";
		return $this;
	}

	public function orColumn(string $column): self
	{
		self::$query .= " OR $column ";
		return $this;
	}

	public function andColumn(string $column): self
	{
		self::$query .= " AND $column ";
		return $this;
	}

	public function isNull(): self
	{
		self::$query .= ' IS NULL ';
		return $this;
	}

	public function notNull(): self
	{
		self::$query .= ' IS NOT NULL ';
		return $this;
	}

	public function in(array $values): self
	{
        $items = '';

        foreach ($values as $value) {
            $items .= '?, ';
            self::$args[] = $value;
        }

        $items = rtrim($items, ', ');

		self::$query .= ' IN (' . $items . ') ';
		return $this;
    }
    
	public function notIn(array $values): self
	{
        $items = '';

        foreach ($values as $value) {
            $items .= '?, ';
            self::$args[] = $value;
        }

        $items = rtrim($items, ', ');

		self::$query .= ' NOT IN (' . $items . ') ';
		return $this;
    }

	public function between($start, $end): self
	{
		self::$query .= " BETWEEN $start AND $end ";
		return $this;
    }
    
	public function notBetween($start, $end): self
	{
		self::$query .= " NOT BETWEEN $start AND $end ";
		return $this;
    }

	public function like($value): self
	{
		self::$query .= " LIKE '%$value%' ";
		return $this;
	}

	public function notLike($value): self
	{
		self::$query .= " NOT LIKE '%$value%' ";
		return $this;
	}

	public function and(string $column, $operator = null, $value = null): self
	{
        if (!is_null($operator) && is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

		self::$query .= " AND $column $operator ? ";
		self::$args[] = $value;
		return $this;
	}

	public function or(string $column, $operator = null, $value = null): self
	{
        if (!is_null($operator) && is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

		self::$query .= " OR $column $operator ? ";
		self::$args[] = $value;
		return $this;
	}

	public function having(string $column, $operator = null, $value = null): self
	{
        if (!is_null($operator) && is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

		self::$query .= " HAVING $column $operator ? ";
		self::$args[] = $value;
		return $this;
	}
        
    public function havingRaw(string $query, array $args = []): self
    {
        return $this->rawQuery(' HAVING ' . $query, $args);
    }

	public function orderBy(string $column, string $direction): self
	{
		self::$query .= " ORDER BY $column " . strtoupper($direction);
		return $this;
	}

	public function groupBy(string ...$columns): self
	{
		self::$query .= ' GROUP BY ';

		foreach ($columns as $column) {
			self::$query .= "$column, ";
		}

		self::$query = rtrim(self::$query, ', ');
		return $this;
	}

	public function limit(int $limit, ?int $offset = null): self
	{
		self::$query .= " LIMIT $limit";

		if (!is_null($offset)) {
			self::$query .= ", $offset";
		}

		return $this;
	}

	public function innerJoin(string $table, string $first_column, string $operator, string $second_column): self
	{
		self::$query .= " INNER JOIN " . config('database.table_prefix') . "$table ON $first_column $operator $second_column";
		return $this;
	}

	public function leftJoin(string $table, string $first_column, string $operator, string $second_column): self
	{
		self::$query .= " LEFT JOIN " . config('database.table_prefix') . "$table ON $first_column $operator $second_column";
		return $this;
	}

	public function rightJoin(string $table, string $first_column, string $operator, string $second_column): self
	{
		self::$query .= " RIGHT JOIN " . config('database.table_prefix') . "$table ON $first_column $operator $second_column";
		return $this;
	}

	public function fullJoin(string $table, string $first_column, string $operator, string $second_column): self
	{
		self::$query .= " FULL JOIN " . config('database.table_prefix') . "$table ON $first_column $operator $second_column";
		return $this;
	}

	public function outerJoin(string $table, string $first_column, string $operator, string $second_column): self
	{
		self::$query .= " FULL OUTER JOIN " . config('database.table_prefix') . "$table ON $first_column $operator $second_column";
		return $this;
	}

    /**
     * Flush query string by removing latest comma
     */
    public function flush(): self
    {
        self::$query = rtrim(self::$query, ', ');
        return $this;
    }

    public function exists(): bool
    {
        if ($this->fetch() === false) {
            return false;
        }

        return true;
    }

	public function toSQL(): array
	{
        $this->trimQuery();
		return [self::$query, self::$args];
	}

	public static function setQuery(string $query, array $args = []): self
	{
		self::$query = $query;
		self::$args = $args;
		return new self();
    }
    
    public function rawQuery(string $query, array $args = []): self
    {
        self::$query .= ' ' . $query;
        self::$args = array_merge(self::$args, $args);
        return $this;
    }
    
    public function subQuery($callback): self
    {
        if (!is_null($callback)) {
            call_user_func_array($callback, [$this]);
        }
        
        return $this;
    }
	
	public function execute()
	{
        $this->trimQuery();
        $stmt = Database::connection()->executeQuery(self::$query, self::$args);
		self::setQuery('');
		return $stmt;
    }

    public function fetch()
    {   
        return $this->execute()->fetch();
    }
    
    public function fetchAll(): array
    {
        return $this->execute()->fetchAll();
    }
        
    public static function lastInsertedId(): int
    {
        return self::setQuery('SELECT LAST_INSERT_ID()')->execute()->fetchColumn();
    }
    
    private function trimQuery()
    {
        self::$query = trim(self::$query);
        self::$query = str_replace('  ', ' ', self::$query);
    }
}
