<?php
/**
 * User: keven
 * Date: 2016/11/7
 * Time: 15:26
 */

namespace common\component;


use common\models\model\VideoInfo;
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
    public function batchSaveTags($videoId,array $tagIds)
    {
        if(empty($tagIds)) return true;
        $tagsData = [];
        foreach($tagIds as $tagId){
                array_push($tagsData,[(int)$videoId,(int)$tagId]);
        }
        return \Yii::$app->db->createCommand()
           ->batchInsert('t_video_tag_pivot',['video_id','tag_id'],$tagsData)
           ->execute();
    }

    public function findAllVideo()
    {

    }
    /**
     * 批量删除标签
     * @param $videoId
     * @param array $tagIds
     * @return bool
     */
    public function batchDelTags($videoId,array $tagIds){
        if(empty($tagIds)) return true;
        foreach ($tagIds as $tagId){
            if(!$this->delTag($videoId,$tagId)){
                return false;
            }
        }
        return true;
    }

    /**
     * 删除指定videoId 和 tagId的标签
     * @param $videoId
     * @param $tagId
     * @return bool|int
     */
    public function delTag($videoId,$tagId){
        if(empty($videoId) || empty($tagId)) return true;
        return \Yii::$app->db->createCommand()
            ->delete('t_video_tag_pivot',['video_id'=>$videoId,'tag_id'=>$tagId])
            ->execute();
    }

    /**
     * 处理新旧标签的方法,自动完成增加、删除标签的功能,
     * @param $videoId
     * @param array $oldTags
     * @param array $newTags
     * @return bool
     */
    public function progressTag($videoId,array $oldTags, array $newTags)
    {
        $delTags = array_diff($oldTags,$newTags);//在oldTags而不在newTags中
        $addTags = array_diff($newTags,$oldTags);
        VarDumper::dump($delTags);VarDumper::dump($addTags);
        if($this->batchDelTags($videoId,$delTags) && $this->batchSaveTags($videoId,$addTags)){
            return true;
        }
        return false;
    }
    /**
     * 通过videoId获得其标签id
     * @param $videoId
     * @param bool $returnArray
     * @return array
     */
    public function getTagIdsByVideoId($videoId,$returnArray = true)
    {
        $tagIds = [];
        $command = (new Query())->select('tag_id')->from('t_video_tag_pivot')->where(['video_id'=>$videoId]);
        $result = $command->all();
        if($returnArray){
            foreach ($result as $item){
                $tagIds[] = $item['tag_id'];
            }
            $result = $tagIds;
        }
        return $result;
    }
    public function getTagByVideoId($videoId)
    {
        /*
         sql:
         ---------------------------------------
          select t.name
          from  t_video_tag_pivot as vtp,t_tag as t
          where vtp.tag_id = t.id
          and vtp.video_id=1
         ---------------------------------------
        以(new Query)的方式查询预留,暂时使用原始sql执行
         */
        $sql = 'select t.id,t.name from t_video_tag_pivot as vtp,t_tag as t where vtp.tag_id = t.id and vtp.video_id=:videoId';
        $command = \Yii::$app->db->createCommand($sql)->bindValue(':videoId',$videoId);
        return $command->queryAll();
    }
    /**
     * 根据标签名id查找视频id
     * @param array $tags
     * @return array
     */
    public function getVideoByTagIds(array $tags)
    {
        if(empty($tagIds)) return [];
        return (new Query())->select('video_id')
            ->from('t_video_tag_pivot')
            ->where(['tag'=>$tags])
            ->all();
    }

    /*

    sql:
    ----------------------------------------------------
    SELECT *
    FROM t_video_info
    WHERE id IN (
		SELECT video_id
		FROM t_video_tag_pivot
		WHERE tag_id = 999
	)
    ---------------------------------------------------
    */
    public function getVideoByTagId($tagId){
        $sql = 'select * from t_video_info where id IN (select video_id FROM  t_video_tag_pivot WHERE tag_id=:tagId)';
        $command = \Yii::$app->db->createCommand($sql)->bindValue(':tagId',$tagId);
        return $command->queryAll();
    }
}