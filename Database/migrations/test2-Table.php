<?php 
use support\Database\schema;
use support\Database\create;

class test2{
    public function up(){
        $users2 = new schema();
        $users2->create("test2", function (create $table) {
            $table->id();
            $table->created_at();
        });
    }
}