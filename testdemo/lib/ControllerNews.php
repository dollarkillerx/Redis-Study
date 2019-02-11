<?php

/**
 * Class ControllerNews
 */
class ControllerNews
{
    public function index()
    {
        $nid = intval(App::get('nid', 0));
        if($nid < 1)
        {
            App::_404();
        }

        $newsModel = ModelNews::getInstance();
        $news = $newsModel->getNewsById($nid);
        if(empty($news))
        {
            App::_404();
        }

        $commentCount = $newsModel->getCommentCount($nid);

        $title = $news['title'];
        $tid = $news['tid'];
        $mysqli = DBMysqli::getInstance();
        $res = $mysqli->query("select `name` from `news_type` where `id` = {$tid} limit 1");
        if(!$res)
        {
            $type = '未知';
        }
        else
        {
            $arr = $res->fetch_assoc();
            $type = $arr['name'];
        }

        include_once VIEW_PATH . '/news.tpl';
    }
}
