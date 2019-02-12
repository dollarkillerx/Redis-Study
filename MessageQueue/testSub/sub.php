<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午4:08
 */
include_once './GetRedis.php';
//监听者
$redis = GetRedis::getInstance();

echo 'reading C1,C2...\n';
$redis->setOption(Redis::OPT_READ_TIMEOUT,-1);
$redis->subscribe(['C1','C2'],function (Redis $instance,$channel,$msg){ //第一个是redis实例 ,第二个监听的渠道,监听到的内容
    echo "recieve message from {$channel}:{$msg}\n";
});