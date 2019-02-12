<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午4:29
 */
$tid = intval($_GET['tid']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Content</title>
</head>
<body>
    <h1>这是内容页面:<?=$tid?></h1>
    <ul>
        <li><a href="article.php?aid=1">文章1</a></li>
        <li><a href="article.php?aid=2">文章2</a></li>
        <li><a href="article.php?aid=3">文章3</a></li>
    </ul>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
    <script>
        $.get("ajax.php?action=pv&from=list&tid=<?=$tid?>");
    </script>
</body>
</html>
