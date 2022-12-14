<?php 
use support\Database\schema;
use support\Database\create;

class transaction{
    public function up(){
        $users2 = new schema();
        $users2->create("transaction", function (create $table) {
            $table->id();
            $table->created_at();
        });
    }
}