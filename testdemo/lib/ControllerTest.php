<?php

class ControllerTest
{
    public function test()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6380);
    }
}
