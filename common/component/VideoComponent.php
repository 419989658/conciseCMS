<?php
/**
 * User: keven
 * Date: 2016/11/7
 * Time: 15:26
 */

namespace common\component;


use yii\base\Component;
use yii\db\Query;
use yii\helpers\VarDumper;

class VideoComponent extends Component
{
    /**
     * 批量插入视频的标签
     * @param $videoId
     * @param $tagIds
     * @return int
     */
    public function batchSaveTags($videoId,$tagIds)
    {
        $tagsData = [];
        foreach($tagIds as $tagId){
            if(is_integer($tagId)){
                array_push($tagsData,[$videoId,$tagId]);
            }
        }
       return \Yii::$app->db->createCommand()
           ->batchInsert('t_video_tag_pivot',['video_id','tag_id'],$tagsData)
           ->execute();
    }
    public function getTagsByVideoId($videoId,$returnArray = true)
    {
        $tagIds = [];
        $command = (new Query())->select('id')->from('t_video_tag_pivot')->where(['video_id'=>$videoId]);
        $result = $command->all();
        foreach ($result as $item){
            $tagIds[] = $item['id'];
        }
        return $tagIds;
    }
}