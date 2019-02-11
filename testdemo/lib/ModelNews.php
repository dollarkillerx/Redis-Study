<?php

/**
 * Class ModelNews
 */
class ModelNews
{
    private static $instance = null;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new ModelNews();
        }
        return self::$instance;
    }

    /**
     * @param int $nid
     * @return int
     */
    public function getCommentCount($nid)
    {
        $nid = intval($nid);
        $mysqli = DBMysqli::getInstance();
        $res = $mysqli->query("select count(1) as `c` from news_comment where `nid` = {$nid}");
        $arr = $res->fetch_assoc();
        if(empty($arr))
        {
            return 0;
        }
        return $arr['c'];
    }

    /**
     * @param int $nid
     * @return array
     */
    public function getNewsById($nid)
    {
        $nid = intval($nid);
        $mysqli = DBMysqli::getInstance();
        $res = $mysqli->query("select * from news where `id` = {$nid}");
        $arr = $res->fetch_assoc();
        if(empty($arr))
        {
            return [];
        }
        return $arr;
    }

    /**
     * 获取用户在一个分类的pv量
     * @param int $uid
     * @param int $tid
     * @return int
     */
    public function getUserPv($uid, $tid)
    {
        $uid = intval($uid);
        $tid = intval($tid);
        $redis = CacheRedis::getInstance();
        $key = Consts::KEYPREIX_USER_PV.$uid;
        $pv = $redis->hGet($key,$tid);
        return $pv;
//        $mysqli = DBMysqli::getInstance();
//        $res = $mysqli->query("select `pv` from `user_pv` where `uid` = {$uid} and `tid` = {$tid} limit 1");
//        $arr = $res->fetch_assoc();
//        if(empty($arr))
//        {
//            return 0;
//        }
//        return $arr['pv'];
    }

    /**
     * 添加用户的分类pv
     * @param int $uid
     * @param int $tid
     */
    public function addUserPv($uid, $tid)
    {
        //1: 1->5, 2->8, 3->9
        $uid = intval($uid);
        $tid = intval($tid);
        $redis = CacheRedis::getInstance();
        $key = Consts::KEYPREIX_USER_PV.$uid;
        $redis->hIncrBy($key,$tid,1);
        return ;
        $pv = $this->getUserPv($uid, $tid);
        $mysqli = DBMysqli::getInstance();
        if(0 == $pv)
        {
            $mysqli->query("insert into `user_pv` (`uid`, `tid`, `pv`) values ({$uid}, {$tid}, 1)");
        }
        else
        {
            $newPv = $pv + 1;
            $mysqli->query("update `user_pv` set `pv` =  {$newPv} where `uid` = {$uid} and `tid` = {$tid} limit 1");
        }
    }

    /**
     * 添加一条评论
     * @param int $uid
     * @param int $nid
     */
    public function addComment($uid, $nid)
    {
        $mysqli = DBMysqli::getInstance();
        $nowTime = date('Y-m-d H:i:s');
        $mysqli->query("insert into `news_comment` (`nid`, `authorid`, `content`, `pubtime`) values ({$nid}, {$uid}, '', '{$nowTime}')");
    }

    /**
     * @param int $uid
     * @return string
     */
    public function getMostPvType($uid)
    {
        $redis = CacheRedis::getInstance();
        $key = Consts::KEYPREIX_USER_PV.$uid;
        //非常小的数据可以hgetall
        $data = $redis->hGetAll($key);
        if (!$data)
        {
            $tid = 1;
        }else{
            arsort($data);
            $keys = array_keys($data);
            $tid = current($keys);
        }
        $mysqli = DBMysqli::getInstance();
        $res = $mysqli->query("select `name` from `news_type` where `id` = {$tid} limit 1");
        if(!$res)
        {
            return '';
        }
        $arr = $res->fetch_assoc();
        return $arr['name'];
        return ;
        
//        $res = $mysqli->query("select * from `user_pv` where `uid`={$uid} order by `pv` desc limit 1");
//        $res =
        if(!$res)
        {
            $tid = 1;
        }
        else
        {
            $arr = $res->fetch_assoc();
            $tid = $arr['tid'];
        }

    }

    /**
     * 获取新闻分类列表
     * @return array
     */
    public function getTypeList()
    {
        $mysqli = DBMysqli::getInstance();
        $res = $mysqli->query('select * from `news_type`');
        if(!$res)
        {
            return [];
        }
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * 根据分页获取新闻列表
     * @param $page
     * @return array
     */
    public function getPageList($page)
    {
        $pagesize = 10;
        $offset = ($page - 1) * $pagesize;
        $mysqli = DBMysqli::getInstance();
        $res = $mysqli->query("select * from `news` limit {$offset}, {$pagesize}");
        if(!$res)
        {
            return [];
        }
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * 获取一个分类的新闻总数
     * @param int $tid
     * @return int
     */
    public function getTypeCount($tid)
    {
        $mysqli = DBMysqli::getInstance();
        $res = $mysqli->query("select count(1) as `c` from `news` where `tid` = {$tid}");
        if(!$res)
        {
            return 0;
        }
        $arr = $res->fetch_assoc();
        return $arr['c'];
    }
}
