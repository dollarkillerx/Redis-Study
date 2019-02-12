<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午4:13
 */
include_once './GetRedis.php';
//发布者
$redis = GetRedis::getInstance();

$res = $redis->publish('C1','你好');
echo "clients:{$res}\n";

$res = $redis->publish('C2','你好c2');
echo "clients:{$res}\n";

$res = $redis->publish('C1','你好c1');
echo "clients:{$res}\n";

$res = $redis->publish('C3','你好c3');
echo "clients:{$res}\n";