<?php

/**
 * Class ControllerApi
 */
class ControllerApi
{
    public function addpv()
    {
        //redis缓存
        $redis = CacheRedis::getInstance();
        $redis->incrBy(Consts::KEY_PV,1);
        return;

        $mysqli = DBMysqli::getInstance();
        $res = $mysqli->query("select * from `site_info` where `info_key` = 'pv'");
        if(0 == $res->num_rows)
        {
            $obj = $mysqli->prepare("insert into `site_info` (`info_key`, `info_value`) values (?, ?)");
            $obj->bind_param('ss', $key, $value);
            $key = 'pv';
            $value = '1';
            $obj->execute();
            $lastPv = 1;
        }
        else
        {
            $arr = $res->fetch_assoc();
            $lastPv = $arr['info_value'];
        }
        $obj = $mysqli->prepare("update `site_info` set `info_value` = ? where `info_key` = 'pv'");
        $obj->bind_param('s', $pv);
        $pv = $lastPv + 1;
        $obj->execute();
    }

    public function adduserpv()
    {
        $uid = intval(App::get('uid'));
        $nid = intval(App::get('nid'));
        if($uid < 1 || $nid < 1)
        {
            return;
        }
        $newsModel = ModelNews::getInstance();
        $news = $newsModel->getNewsById($nid);
        if(empty($news))
        {
            return;
        }
        $tid = $news['tid'];
        $newsModel->addUserPv($uid, $tid);
    }


    public function addnews()
    {
        $mysqli = DBMysqli::getInstance();
        $tid = mt_rand(1, 12);
        $title = '测试标题' . mt_rand(100000, 999999);
        $nowTime = date('Y-m-d H:i:s');
        $mysqli->query("insert into `news` (`authorid`, `tid`, `title`, `content`, `pubtime`, `uptime`) values (1, {$tid}, '{$title}', '', '{$nowTime}', '{$nowTime}')");
        $res = $mysqli->query("select `name` from `news_type` where `id` = {$tid} limit 1");
       $name = '';
       if($res)
        {
           $arr = $res->fetch_assoc();
           $name = $arr['name'];
       }

        $redis = CacheRedis::getInstance();
        $key = Consts::KEYPREFIX_TID_COUNT.$tid;
        $redis->hSet($key,'id',$tid);
        $redis->hSet($key,'name',$name);
        $redis->hIncrBy($key,'count',1);
    }


    public function addcomment()
    {
        $uid = intval(App::get('uid'));
        $nid = intval(App::get('nid'));
        if($uid < 1 || $nid < 1)
        {
            return;
        }
        $newsModel = ModelNews::getInstance();
        $newsModel->addComment($uid, $nid);
    }

    public function getweather()
    {
        $city = App::get('city', '');
        //todo 请求第三方
        //北京->晴天
        //上海->下雨
        $redis = CacheRedis::getInstance();
        $weather = $redis->hGet(Consts::KEY_CITY_WEATHER,$city);
        
        $arr = ['city' => $city, 'weather' => $weather];
        echo json_encode($arr);
    }
}
