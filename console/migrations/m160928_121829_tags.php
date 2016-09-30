<?php

use yii\db\Migration;

class m160928_121829_tags extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable("{{%tags}}",[
            'id'=>$this->primaryKey(),
            'tag'=>$this->string()->notNull(),
            'meta_description'=>$this->string(),
            'tag_img'=>$this->string(),
            'created_at'=>$this->integer()->notNull(),
            'updated_at'=>$this->integer()->notNull(),
        ],$tableOptions);
    }

    public function down()
    {
        echo "m160928_121829_tags cannot be reverted.\n";

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
