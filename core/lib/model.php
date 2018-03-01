<?php

namespace core\lib;

use \Medoo\Medoo;

class model extends MEDOO
{
    public $db;

    public function __construct()
    {
        $database = conf::all('database');
        $this->db = parent::__construct($database);

    }
}