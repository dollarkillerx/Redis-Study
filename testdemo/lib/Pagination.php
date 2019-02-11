<?php

/**
 * Class Pagination
 */
class Pagination
{
    /**
     * @const int ITEM_SHOW_ALLWAYS 链接一直显示
     */
    const ITEM_SHOW_ALLWAYS = 2;

    /**
     * @const int ITEM_SHOW_DEPENDS 链接根据情况显示(如第1页不显示首页 第2页显示首页)
     */
    const ITEM_SHOW_DEPENDS = 1;
    
    /**
     * @const int ITEM_SHOW_NO 链接从不显示
     */
    const ITEM_SHOW_NO = 0;

    /**
     * @var int $total 总页数
     */
    private $total = 1;

    /**
     * @var int $current 当前页
     */
    private $current = 1;

    /**
     * @var array $queryArr 页码链接的query
     */
    private $queryArr = [];

    /**
     * @var string $wrapper 顶级容器
     */
    private $wrapper = 'ul';

    /**
     * @var string $wrapperClass 顶级容器的class
     */
    private $wrapperClass = 'pagination pagination-sm no-margin pull-right';

    /**
     * @var string $itemWrapper 链接容器
     */
    private $itemWrapper = 'li';

    /**
     * @var string $itemWrapperClass 链接容器的class
     */
    private $itemWrapperClass = '';

    /**
     * @var string $disabledItem 不能点击的链接
     */
    private $disabledItem = 'a';

    /**
     * @var string $disabledHref 不能点击的链接的href
     */
    private $disabledHref = 'javascript:;';

    /**
     * @var string $disabledClass 不能点击的链接的class
     */
    private $disabledClass = '';

    /**
     * @var string $disabledWrapperClass 不能点击的链接的容器的class
     */
    private $disabledWrapperClass = 'disabled';

    /**
     * @var string $currentClass 当前页的class
     */
    private $currentClass = '';

    /**
     * @var string $currentWrapperClass 当前页的容器的class
     */
    private $currentWrapperClass = 'active';

    /**
     * @var string $item 链接标签
     */
    private $item = 'a';

    /**
     * @var string $itemClass 链接的class
     */
    private $itemClass = '';

    /**
     * @var string $firstText 首页文字
     */
    private $firstText = '';

    /**
     * @var string $prevText 上一页文字
     */
    private $prevText = '上一页';

    /**
     * @var string $prevClass 上一页class
     */
    private $prevClass = '';

    /**
     * @var string $nextText 下一页文字
     */
    private $nextText = '下一页';

    /**
     * @var string $nextClass 下一页class
     */
    private $nextClass = '';

    /**
     * @var string $lastText 末页文字
     */
    private $lastText = '';

    /**
     * @var int $showFirst 首页显示状态
     */
    private $showFirst = self::ITEM_SHOW_DEPENDS;

    /**
     * @var int $showPrev 上一页显示状态
     */
    private $showPrev = self::ITEM_SHOW_DEPENDS;

    /**
     * @var int $showNext 下一页显示状态
     */
    private $showNext = self::ITEM_SHOW_DEPENDS;

    /**
     * @var int $showLast 末页显示状态
     */
    private $showLast = self::ITEM_SHOW_DEPENDS;

    /**
     * @var array $itemList 页码链接顺序
     */
    private $itemList = [
        'prev',
        'first',
        'ldot',
        'pages',
        'rdot',
        'last',
        'next'
    ];

    /**
     * Pagination constructor.
     * @param int $total 总页数
     * @param int $current 当前页
     * @param array $queryArr 页面链接附加query
     * @param array $param 配置
     */
    public function __construct($total, $current, $queryArr = [], $param = [])
    {
        $this->total = $total;
        $this->current = $current;
        if(empty($queryArr) && !empty($_GET))
        {
            $queryArr = $_GET;
        }
        $this->queryArr = $queryArr;
        if(!empty($param))
        {
            foreach($param as $k => $v)
            {
                $this->$k = $v;
            }
        }
    }

    /**
     * 生成pagination
     * @return string
     */
    public function gen()
    {
        $str = '';
        //容器
        if(!empty($this->wrapper))
        {
            $str = "<{$this->wrapper} class=\"{$this->wrapperClass}\">\n";
        }
        foreach($this->itemList as $v)
        {
            $isShow = $this->_judgeShow($v);
            if('pages' == $v)
            {
                //前三页
                for($i = 0; $i < 3; $i ++)
                {
                    $pageNum = $this->current - 3 + $i;
                    if($pageNum < 2)
                    {
                        continue;
                    }
                    $str .= $this->_genPageLink($pageNum);
                }
                //当前页
                $str .= $this->_genPageLink('current');
                //后三页
                $afterCount = $this->total - $this->current - 1;
                if($afterCount >= 4)
                {
                    $afterCount = 3;
                }
                for($i = 0; $i < $afterCount; $i ++)
                {
                    $str .= $this->_genPageLink($i + 1 + $this->current);
                }
            }
            else
            {
                //特殊链接
                if($isShow)
                {
                    $str .= $this->_genPageLink($v);
                }
            }
        }
        if(!empty($this->wrapper))
        {
            $str .= "</{$this->wrapper}>\n";
        }
        return $str;
    }

    /**
     * 生成一个页码的链接DOM
     * @param string $name
     * @return string
     */
    private function _genPageLink($name)
    {
        list($url, $text) = $this->_getPageLinkUrlText($name);

        $str = '';
        $isCurrent = 'current' == $name;
        $hasItemwrapper = !empty($this->itemWrapper);

        //item容器
        if($hasItemwrapper)
        {
            if($isCurrent)
            {
                $wrapperClass = $this->currentWrapperClass;
            }
            else
            {
                $wrapperClass = !$url ? $this->disabledWrapperClass : $this->itemWrapperClass;
            }
            $str .= "<{$this->itemWrapper} class=\"{$wrapperClass}\">\n";
        }

        //item itemhref
        if(!$url)
        {
            $item = $this->disabledItem;
            $itemHref = $this->disabledHref;
        }
        else
        {
            $item = $this->item;
            $itemHref = $url;
        }
        if('a' == $item)
        {
            $itemHref = "href=\"{$itemHref}\"";
        }
        else
        {
            $itemHref = '';
        }

        //itemclass
        $itemClass = $this->_getItemClass($name, !$url);

        $str .= "<{$item} class=\"{$itemClass}\" {$itemHref}>{$text}</{$item}>\n";
        if($hasItemwrapper)
        {
            $str .= "</{$this->itemWrapper}>\n";
        }
        return $str;
    }

    /**
     * 获取链接class
     * @param $name
     * @param $isDisabled
     * @return string
     */
    private function _getItemClass($name, $isDisabled)
    {
        $class = $isDisabled ? $this->disabledClass : $this->itemClass;
        switch($name)
        {
            //todo 其他可能性
            case 'prev':
                if(!empty($this->prevClass))
                {
                    $class = $this->prevClass;
                }
                break;
            case 'next':
                if(!empty($this->nextClass))
                {
                    $class = $this->nextClass;
                }
                break;
            case 'current':
                if(!empty($this->currentClass))
                {
                    $class = $this->currentClass;
                }
                break;
            default:
                break;
        }
        return $class;
    }

    /**
     * 获取链接的url和text
     * @param $name
     * @return array
     */
    private function _getPageLinkUrlText($name)
    {
        if(is_numeric($name))
        {
            $page = $name;
            $text = $name;
        }
        else
        {
            $pageMap = [
                'first' => [
                    1,
                    $this->firstText
                ],
                'prev' => [
                    $this->current - 1,
                    $this->prevText
                ],
                'current' => [
                    $this->current,
                    $this->current
                ],
                'next' => [
                    $this->current + 1,
                    $this->nextText
                ],
                'last' => [
                    $this->total,
                    $this->lastText
                ],
                'ldot' => [
                    0,
                    '&hellip;'
                ],
                'rdot' => [
                    0,
                    '&hellip;'
                ]
            ];
            if(isset($pageMap[$name]))
            {
                $page = $pageMap[$name][0];
                $text = $pageMap[$name][1];
            }
            else
            {
                $page = 1;
                $text = '-1';
            }
        }
        if($page < 1 || $page == $this->current || $page > $this->total)
        {
            $url = false;
        }
        else
        {
            unset($this->queryArr['page']);
            if($page > 1)
            {
                $this->queryArr['page'] = $page;
            }
            $url = '?' . http_build_query($this->queryArr);
        }
        $text = $text ?: $page;
        return [
            $url,
            $text
        ];
    }

    /**
     * 判断特殊链接是否显示
     * @param string $name
     * @return bool
     */
    private function _judgeShow($name)
    {
        switch($name)
        {
            case 'first':
                return self::ITEM_SHOW_ALLWAYS == $this->showFirst || (self::ITEM_SHOW_DEPENDS == $this->showFirst && $this->current > 1);
            case 'prev':
                return self::ITEM_SHOW_ALLWAYS == $this->showPrev || (self::ITEM_SHOW_DEPENDS == $this->showPrev && $this->current > 1);
            case 'next':
                return self::ITEM_SHOW_ALLWAYS == $this->showNext || (self::ITEM_SHOW_DEPENDS == $this->showNext && $this->current < $this->total);
            case 'last':
                return self::ITEM_SHOW_ALLWAYS == $this->showLast || (self::ITEM_SHOW_DEPENDS == $this->showLast && $this->current < $this->total);
            case 'ldot':
                return $this->current > 4;
            case 'rdot':
                return $this->current + 3 < $this->total;
            default:
                return true;
        }
    }
}
