<?php 
use support\Database\schema;
use support\Database\create;

class Eric{
    public function up(){
        $schema = new schema();
        $schema->create("Eric", function (create $table) {
            $table->id();
            $table->created_at();
        });
    }
}