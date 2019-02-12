<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午2:50
 */

class GetDb
{
    private static $instance = null;
    public static function getInstance()
    {
        if (is_null(self::$instance)){
            $serverHost = '127.0.0.1';
            $username = 'test_study';
            $password = '4EjPXm5neJifFPp4';
            $dbName = 'test_study';
            self::$instance = new PDO("mysql:host=$serverHost;dbname=$dbName",$username,$password);
            self::$instance->exec("SET NAMES UTF8");
        }
        return self::$instance;
    }
}