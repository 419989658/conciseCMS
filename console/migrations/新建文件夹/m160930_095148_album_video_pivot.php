<?php

use yii\db\Migration;

class m160930_095148_album_video_pivot extends Migration
{
    private $tableName = "{{%album_video_pivot}}";
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName,[
            'id'=>$this->primaryKey(),
            'album_id'=>$this->integer(11)->notNull(),
            'video_id'=>$this->integer(11)->notNull(),
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
