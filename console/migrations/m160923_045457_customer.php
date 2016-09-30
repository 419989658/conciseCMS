<?php

use yii\db\Migration;

class m160923_045457_customer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName = 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%customer}}', [
                'id'=>$this->primaryKey(),
                'name'=>$this->string(60)->notNull(),
                'sex'=>$this->integer(1),
                'birthday'=>$this->integer(11),
                'created_at'=>$this->integer()->notNull(),
                'updated_at'=>$this->integer()->notNull(),
        ], $tableOptions
        );
    }

    public function down()
    {
        echo "m160923_045456_customer cannot be reverted.\n";

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
