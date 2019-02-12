<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午3:39
 */
include_once './GetRedis.php';
$redis = GetRedis::getInstance();
$redis->select(0);
$key = "list:index";
while (true)
{
    if (false !==$redis->lPop($key)){
        $redis->incrBy("pv:index",1);
    }
}