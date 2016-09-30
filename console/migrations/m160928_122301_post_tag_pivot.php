<?php

use yii\db\Migration;

class m160928_122301_post_tag_pivot extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable("{{%post_tag_pivot}}",[
            'id'=>$this->primaryKey(),
            'post_id'=>$this->integer()->unsigned()->notNull(),
            'tag_id'=>$this->integer()->unsigned()->notNull(),
        ],$tableOptions);

        $this->createIndex(
            'idx-post_tag_pivot-post_id',
            "{{%post_tag_pivot}}",
            'post_id'
        );
        $this->createIndex(
            'idx-post_tag_pivot-tag_id',
            "{{%post_tag_pivot}}",
            'tag_id'
        );
    }

    public function down()
    {
        echo "m160928_122301_post_tag_pivot cannot be reverted.\n";

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
