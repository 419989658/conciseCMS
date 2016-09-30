<?php

use yii\db\Migration;

class m160930_093007_video_info extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable("{{%video_info}}",[
            'id'=>$this->primaryKey(),
            'name'=>$this->string(100)->notNull(),  //影片名称
            'actors'=>$this->string()->notNull(),   //演员名称  多个演员用逗号隔开
            'issue_date'=>$this->integer(11),       //发行时间
            'cover_img'=>$this->string(),           //封面图片
            'thumb_img'=>$this->string(),           //缩略图
            'play_url'=>$this->string(),            //观看地址
            'status'=>$this->integer(1)->defaultValue(1),// 0表示正常 1表示正在转码中,2表示转码失败
            'created_at'=>$this->integer(11),
            'updated_at'=>$this->integer(11),
        ],$tableOptions);
    }

    public function down()
    {
        echo "m160930_093007_video_info cannot be reverted.\n";

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
