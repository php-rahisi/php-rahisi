<?php
namespace App\Models;

use support\Database\table;

class transaction extends table
{
    
    public $table = 'transaction';

    public function __construct()
    {
        new table($this->table);
    }
}