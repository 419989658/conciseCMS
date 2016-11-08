<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\model\Tag]].
 *
 * @see \common\models\model\Tag
 */
class TagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\model\Tag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\model\Tag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
