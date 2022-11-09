<?php
namespace App\Models;

use support\Database\table;

class test extends table
{
    
    public $table = 'test';

    public function __construct()
    {
        new table($this->table);
    }
}