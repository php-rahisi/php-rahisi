<?php
namespace App\Models;

use support\Database\table;

class test2 extends table
{
    
    public $table = 'test2';

    public function __construct()
    {
        new table($this->table);
    }
}