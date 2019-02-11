<?php

/**
 * Class ControllerIndex
 */
class ControllerIndex
{
    public function index()
    {
        $redis = CacheRedis::getInstance();
        // $redis = CacheRedis::getInstance();

        //获取用户浏览量最多的新闻分类
        $uid = 1;
        $newsModel = ModelNews::getInstance();
        $mostPvType = $newsModel->getMostPvType($uid);
        if(empty($mostPvType))
        {
            $mostPvType = '国内';
        }

        //获取当前pv
        $mysqli = DBMysqli::getInstance();
//               $res = $mysqli->query("select `info_value` from `site_info` where `info_key` = 'pv' limit 1");
//               if(!$res)
//               {
//                   $pv = 0;
//               }
//               else
//               {
//                   $arr = $res->fetch_assoc();
//                   $pv = $arr['info_value'];
//               }
        $pv = $redis->get(Consts::KEY_PV);
        if (!$pv)
        {
            $pv=1;
        }

        //分类预览
        $newsTypes = $newsModel->getTypeList();
        if(!empty($newsTypes))
        {
            foreach($newsTypes as $index => $type)
            {
                $newsTypes[$index]['count'] = $newsModel->getTypeCount($type['id']);
            }
        }

        //根据page获取新闻列表
        $page = intval(App::get('page', 1));
        if($page < 1)
        {
            $page = 1;
        }
        $list = $newsModel->getPageList($page);

        //为每条新闻获取评论数
        if(!empty($list))
        {
            foreach($list as $index => $news)
            {
                $list[$index]['comment_count'] = $newsModel->getCommentCount($news['id']);
            }
        }

        //新闻总数
        $res = $mysqli->query('select count(1) as `c` from `news`');
        if(!$res)
        {
            $total = 0;
            $totalPage = 1;
        }
        else
        {
            $arr = $res->fetch_assoc();
            $total = $arr['c'];
            $totalPage = ceil($total / 10);;
        }

        $pagenation = new Pagination($totalPage, $page);
        $page = $pagenation->gen();
        include_once VIEW_PATH . '/index.tpl';
    }
}
