<?php
/**
 * User: keven
 * Date: 2016/10/24
 * Time: 11:09
 */

namespace common\models;


use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules()
    {
        return[
            [['status'],'integer'],
            [['username','email'],'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' =>$query,
        ]);

        $this->load($params);

        if(!$this->validate()){
            return $dataProvider;
        }

        $query->andFilterWhere(['status'=>$this->status]);
        $query->andFilterWhere(['like','username',$this->username]);
        $query->andFilterWhere(['like','email',$this->email]);

        return $dataProvider;
    }
}