<?php

namespace common\models\query;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\model\VideoInfo;

/**
 * VideoInfoQuery represents the model behind the search form about `common\models\model\VideoInfo`.
 */
class VideoInfoQuery extends VideoInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'actor_id', 'tag_id', 'album_id', 'issue_date', 'play_time', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'cover_img', 'thumb_img', 'play_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VideoInfo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'actor_id' => $this->actor_id,
            'tag_id' => $this->tag_id,
            'album_id' => $this->album_id,
            'issue_date' => $this->issue_date,
            'play_time' => $this->play_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cover_img', $this->cover_img])
            ->andFilterWhere(['like', 'thumb_img', $this->thumb_img])
            ->andFilterWhere(['like', 'play_url', $this->play_url]);

        return $dataProvider;
    }
}
