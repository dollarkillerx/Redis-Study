<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午4:35
 */
include_once './GetRedis.php';
$action = intval($_GET['action']);
$redis = GetRedis::getInstance();

//首页pv
$channelPVindex = 'pv:index';

//列表页PV
$channelPVlist = 'pv:list';

//内容页pv
$channerPvArticle = 'pv:acticle';

//内容页浏览时间超过5s
$channerGt5 = 'gt5:acticle';

if ('pv' == $action)
{
    //pv统计
    $from = intval($_GET['from']);
    if ('index' == $from){
        $redis->publish($channelPVindex,$from);
    }else if('list' == $from){
        $tid = intval($_GET['tid']);
        $redis->publish($channelPVlist,$tid);
    }else if ('article' == $from){
        $aid = intval($_GET['aid']);
        $redis->publish($channerPvArticle,$aid);
    }
}else if ('gt5' == $action){
    //内容页浏览时间超过5s的统计
    $aid = intval($_GET['aid']);
    $redis->publish($channerGt5,$aid);
}else{
    //未知
}