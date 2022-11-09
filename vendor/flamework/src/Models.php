<?php

namespace support;

use support\Database\DB;

class Models extends DB
{
    public $table;
    public function __construct()
    {
        $this->table($this->table);
    }
}
