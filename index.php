<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-11
 * Time: 下午4:12
 */

//$redis = new Redis();
//$redis->connect('127.0.0.1',6379);

//$redis->set('hello','redis.so');
//echo $redis->get('hello');
////$redis->rPush('testList',1);
//$redis->set('age',20);
//$redis->del('age');
//$age = $redis->get('age');
////var_dump($age);
//$isSetAge = $redis->exists('age');
////var_dump($isSetAge);
//$isSetOk = $redis->setnx('age',20);
//var_dump($isSetOk);
//$isSetOk = $redis->setnx('age',20);
//var_dump($isSetOk);

//$pvKey = 'libdata:pv:'.date('Y-m-d');
//if (!$redis->exists($pvKey)){
//    $redis->set($pvKey,1);
//}
//$redis->incrBy($pvKey,1);
//var_dump($redis->get($pvKey));

//$redis = new Redis();
//
//$redis->connect('127.0.0.1',6379);
//
//$userA = [
//    'name'=>'a',
//    'age'=>20
//];
//
//$userB = [
//    'name'=>'b',
//    'age'=>22
//];
//
//$redis->hSet('user:a','name','a');
//$redis->hSet('user:a','age',20);
//
////$db = mysqli_connect()
////$db->query("UPDATE `user` SET `age`=21 WHERE `id`=1")
//$redis->hset('user:a','age',21);

//$redis = new Redis();
//$redis->connect('127.0.0.1',6379);
//$key = "testList";
////$arr = [];
////array_push($arr,1);
////$arr[]=1;
//
//$redis->rPush($key,1);

$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$redis->sAdd('key1','苹果');
$redis->sAdd('key1','香蕉');
//$arr = $redis->sMembers('key1');
//var_dump($arr);
//$num = $redis->sCard('key1');
//var_dump($num);
//$redis->sAdd('key1','dollarkiller');
//$res = $redis->sPop('key1');
//var_dump($res);
$redis->sAdd('key2','香蕉');
$redis->sAdd('key2','dolalrkiller');
$res = $redis->sDiff('key1','key2');
var_dump($res);