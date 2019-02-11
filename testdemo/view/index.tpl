<html>
<head>
    <link rel="stylesheet" href="/static/common.css">
</head>
<body>
<h1>新闻系统</h1>
<div class="block">
    今天的天气是:<span class="data" id="weather">晴</span><br><br>
    您最感兴趣的内容:<span class="data"><?=$mostPvType?></span><br><br>
    本站pv:<span class="data"><?=$pv?></span>
</div>

<div class="block">
    <p>
        分类预览
    </p>
    <ul class="preview">
        <?php foreach($newsTypes as $type): ?>
            <li><?=$type['name']?>:<span class="data"><?=$type['count']?></span>篇</li>
        <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>

<div class="block">
    <p>
        新闻列表
    </p>
    <ul class="pagelist">
        <?php foreach($list as $news): ?>
            <li>
                <a target="_blank" href="<?=App::genUrl('news', 'index', ['nid' => $news['id']])?>"><?=$news['title']?></a>
                (<span class="data"><?=$news['comment_count']?></span>条评论)
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="pagination">
        <?=$page?>
    </div>
</div>

<script src="/static/jquery.2.1.4.min.js"></script>
<script>
    //获取天气
    $.get('/?c=api&a=getweather&city=上海', function (res) {
        var data = JSON.parse(res);
        $('#weather').text(data.weather || '晴');
    });

    //增加pv
    $.get('/?c=api&a=addpv');
</script>
</body>
</html>
