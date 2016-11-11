<?php

use yii\db\Migration;

class m161110_141615_people_table extends Migration
{
    public function up()
    {
        $this->createTable('people',[
            'id'=>$this->primaryKey(),
            'first_name'=>$this->string(),
            'last_name'=>$this->string(),
            'keywords'=>$this->text(),
            'resume'=>$this->string()
        ]);
    }

    public function down()
    {
        echo "m161110_141615_people_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
