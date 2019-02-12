<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午3:25
 */

class GetRedis
{
    private static $instance = null;
    public static function getInstance()
    {
        if (is_null(self::$instance)){
            self::$instance=new Redis();
            self::$instance->connect('127.0.0.1',6379);
        }
        return self::$instance;
    }
}