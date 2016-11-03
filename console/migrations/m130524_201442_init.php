<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    private $tableName = '{{%user}}';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),                 //用户名
            'auth_key' => $this->string(32)->notNull(),                         //验证KEY
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),    //用户email
            'role'=>$this->smallInteger(6)->notNull()->defaultValue('0'),       //角色等级
            'user_img' =>$this->string(255),                                     //用户头像

            'status' => $this->smallInteger()->notNull()->defaultValue(1),      //用户状态
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
       parent::dropTable($this->tableName);
    }
}
