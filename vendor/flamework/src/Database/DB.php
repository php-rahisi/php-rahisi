<?php

namespace support\Database;

use support\Database\select;

class DB
{
   static function select($query, array $binds = null)
   {
      return new select($query, $binds);
   }

   static function selectCollum($query, array $binds = null)
   {
      return new select($query, $binds);
   }

   static function table($table)
   {
      return new table($table);
   }
}
