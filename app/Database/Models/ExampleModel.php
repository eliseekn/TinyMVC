<?php

namespace App\Database\Models;

use Framework\ORM\Model;

/**
 * ExampleModel
 */
class ExampleModel extends Model
{    
    /**
     * name of table
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * instantiates class
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct($this->table);
    }
    
    /**
     * get row
     *
     * @param  string $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        return $this->findWhere('email', '=', $email);
    }
}