<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-11
 * Time: 下午7:35
 */

include_once 'index.php';

$redis = CacheRedis::getInstance();

$cityList = ['北京','上海'];

$weatherList = ['晴','阴','雨','雪','风'];

foreach ($cityList as $city)
{
    $weather = $weatherList[mt_rand(0,count($weatherList)-1)];
    $redis->hSet(Consts::KEY_CITY_WEATHER,$city,$weather);
}
