<?php

/**
 * Class DBMysqli
 */
class DBMysqli
{
    /**
     * @var mysqli mysqli单例
     */
    private static $instance = null;

    public static function getInstance()
    {
        
        if(is_null(self::$instance))
        {
            self::$instance = new mysqli('127.0.0.1', 'test_study', '4EjPXm5neJifFPp4', 'test_study');
            self::$instance->query("set names 'utf8'");
        }
        return self::$instance;
    }
}
