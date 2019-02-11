<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-11
 * Time: 下午8:57
 */

/**
 * 分类预览->redis修正脚本
 */
include_once 'index.php';
$newsModel = ModelNews::getInstance();
$newsTypes = $newsModel->getTypeList();
$redis = CacheRedis::getInstance();
if (!empty($newsTypes)){
    foreach ($newsTypes as $index=>$type)
    {
        $tid = $type['id'];
        $name = $type['name'];
        $count = $newsModel->getTypeCount($type['id']);
        $key = Consts::KEYPREFIX_TID_COUNT.$tid;
//        $redis->hSet($key,'tid',$tid);
//        $redis->hSet($key,'name',$name);
//        $redis->hSet($key,'count',$count);
        $redis->hMSet($key,[
            'tid'=>$tid,
            'name'=>$name,
            'count'=>$count
        ]);
    }
}
