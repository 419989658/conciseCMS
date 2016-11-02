<?php
/**
 * User: keven
 * Date: 2016/10/24
 * Time: 11:44
 */

namespace backend\models;


use common\models\User;
use yii\base\Model;

class AddUserForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules(){
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        $model = new User();
        $model->username = $this->username;
        $model->generateAuthKey();
        $model->setPassword($this->password);
        $model->email = $this->email;
        return $model->save()?$model:null;
    }
}