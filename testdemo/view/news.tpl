<html>
<head>
    <link rel="stylesheet" href="/static/common.css">
</head>
<body>
<h1>新闻内容</h1>
<div class="block">
    标题:<span class="data"><?=$title?></span><br><br>
    所属分类:<span class="data"><?=$type?></span><br><br>
    评论数:<span class="data"><?=$commentCount?></span><br><br>
    本页面将给您在所属分类的pv+1
</div>

<div class="block">
    <button id="addcomment">点击添加一条评论</button>
</div>

<script src="/static/jquery.2.1.4.min.js"></script>
<script>
    //给用户在该分类的pv+1
    $.get('/?c=api&a=adduserpv&uid=1&nid=<?=$nid?>');

    //添加评论
    $('#addcomment').on('click', function () {
        var $this = $(this);
        if ($this.hasClass('disabled')) {
            return;
        }
        $this.addClass('disabled');
        $.get('/?c=api&a=addcomment&uid=1&nid=<?=$nid?>', function (res) {
            $this.removeClass('disabled');
        });
    });
</script>
</body>
</html>
