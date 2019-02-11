<?php

class CacheRedis
{
    /**
     * @var Redis
     */
    private static $instance = null;

    /**
     * @return Redis
     */
    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Redis();
            self::$instance->connect('127.0.0.1', 6379);
        }
        return self::$instance;
    }
}
