<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午4:23
 */
/**
 * 功能1: 统计页,列表页,内容页的PV
 * 功能2: 统计浏览时间超过5秒的内容页
 * 功能3: 内容页的pv+1分,浏览时间超过5s的页面+5分,浏览时间低于5s的页面-1分,生成内容页质量分
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>欢迎访问首页</h1>
    <ul>
        <li><a href="list.php?tid=1">第一类</a></li>
        <li><a href="list.php?tid=2">第二</a></li>
        <li><a href="list.php?tid=3">第三</a></li>
    </ul>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
    <script>
        $.get("ajax.php?action=pv&from=index");
    </script>
</body>
</html>
