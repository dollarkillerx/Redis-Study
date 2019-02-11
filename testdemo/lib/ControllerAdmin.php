<?php

/**
 * Class ControllerAdmin
 */
class ControllerAdmin
{
    public function index()
    {
        include_once VIEW_PATH . '/admin.tpl';
    }
    public function edit()
    {
        $uid = App::get('uid');
        $nid = App::get('nid');
        $newsModel = ModelNews::getInstance();
        $news = $newsModel->getNewsById($nid);
        if(empty($news))
        {
            return;
        }
        $mysqli = DBMysqli::getInstance();
        $nowTime = date('Y-m-d H:i:s');
        $mysqli->query("update `news` set `uptime` = '{$nowTime}' where `id`=  {$nid} limit 1");
        $log = '修改了新闻:' . $news['title'];
        $mysqli->query("insert into `admin_log` (`uid`, `log`, `uptime`) values ({$uid}, '{$log}', '{$nowTime}')");
    }
}
