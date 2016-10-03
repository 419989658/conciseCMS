<?php

use yii\db\Migration;

class m160922_050519_t_posts extends Migration
{
    private $tableName = '{{%posts}}';
    public function up()
    {
        $tableOptions = null;
        if($this->db->driverName = 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName,[
            'id'=>$this->primaryKey(),
            'title'=>$this->string()->notNull(),
            'author'=>$this->string()->notNull(),
            'content'=>$this->text(),
            'status'=>$this->integer(1)->notNull()->defaultValue(1),
            'created_at'=>$this->integer()->notNull(),
            'updated_at'=>$this->integer()->notNull(),
        ],$tableOptions);
    }

    public function down()
    {
        parent::dropTable($this->tableName);
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
