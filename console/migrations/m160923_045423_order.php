<?php

use yii\db\Migration;

class m160923_045423_order extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if($this->db->driverName = 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order}}',[
            'id'=>$this->primaryKey(),
            'customer_id'=>$this->integer()->notNull(),
            'num'=>$this->integer()->notNull()->defaultValue(0),
            'created_at'=>$this->integer()->notNull(),
            'updated_at'=>$this->integer()->notNull(),
        ],$tableOptions);
    }

    public function down()
    {
        echo "m160923_045423_order cannot be reverted.\n";

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
