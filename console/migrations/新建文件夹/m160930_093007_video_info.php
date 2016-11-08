<?php

use yii\db\Migration;

class m160930_093007_video_info extends Migration
{
    private $tableName = "{{%video_info}}";
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName,[
            'id'=>$this->primaryKey(),
            'name'=>$this->string(100)->notNull(),          //影片名称
            'actor_id'=>$this->integer(11)->notNull(),      //演员ID
            'tag_id'=>$this->integer(11)->notNull(),        //标签ID
            'album_id'=>$this->integer(11)->notNull(),      //专辑ID
            'issue_date'=>$this->integer(11),               //发行时间
            'play_time'=>$this->integer(11),                //影片时长
            'cover_img'=>$this->string(),                   //封面图片地址
            'thumb_img'=>$this->string(),                  //缩略图地址
            'origin_url'=>$this->string(),                  //原始视频地址
            'play_url'=>$this->string(),                   //播放地址
            'status'=>$this->integer(1)->defaultValue(1),// 0表示正常 1表示正在转码中,2表示转码失败
            'created_at'=>$this->integer(11),
            'updated_at'=>$this->integer(11),
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
