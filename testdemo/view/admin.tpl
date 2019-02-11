<html>
<head>
    <link rel="stylesheet" href="/static/common.css">
</head>
<body>
<h1>管理员操作</h1>
<div class="block">
    <button id="addnews">点击添加一条新闻</button>
    <label id="res-add"></label>
</div>

<script src="/static/jquery.2.1.4.min.js"></script>
<script>
    //添加新闻
    $('#addnews').on('click', function () {
        var $this = $(this), $resAdd = $('#res-add');
        if ($this.hasClass('disabled')) {
            return;
        }
        $this.addClass('disabled');
        $resAdd.hide();
        $.get('/?c=api&a=addnews', function (res) {
            $this.removeClass('disabled');
            $resAdd.text('您刚添加了一条:' + res).show();
        });
    });
</script>
</body>
</html>
