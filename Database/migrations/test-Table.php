<?php 
use support\Database\schema;
use support\Database\create;

class test{
    public function up(){
        $users2 = new schema();
        $users2->create("test", function (create $table) {
            $table->id();
            $table->created_at();
        });
    }
}