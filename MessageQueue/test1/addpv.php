<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午2:24
 */

/**
include_once './GetDb.php';
//给pv加1
//$serverHost = '127.0.0.1';
//$username = 'test_study';
//$password = '4EjPXm5neJifFPp4';
//$dbName = 'test_study';
try{
//    $conn = new PDO("mysql:host=$serverHost;dbname=$dbName",$username,$password);
    $conn = GetDb::getInstance();
    $sql = "UPDATE `test_tab` SET `value`= `value`+1 WHERE `name` = 'index' ";
    $conn->exec($sql);
//    var_dump($conn);

}catch (PDOException $e)
{
    echo $e->getMessage();
}
 * **/

/**
#redis set方式实现
include_once './GetRedis.php';
$redis = GetRedis::getInstance();
$redis->select(0);
$key = "pv:index";
if (false === $redis->get($key)){
    $redis->set($key,0);
}
$redis->incrBy($key,1);
 * */

#redis list方式实现
include_once './GetRedis.php';
$redis = GetRedis::getInstance();
$redis->select(0);
$key = "list:index";
$redis->rPush($key,1);