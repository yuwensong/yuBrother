<?php

namespace core\lib;

use core\lib\conf;
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