<?php
/**
 * Created by PhpStorm.
 * User: wangye
 * Date: 19-2-12
 * Time: 下午4:32
 */
$aid = intval($_GET["aid"]);
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
<h1>这是文章页面:<?=$aid?></h1>
<main>正文</main>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<script>
    $.get("ajax.php?action=pv&from=article&aid=<?=$aid?>");

    //if 页面打开时间超过5s则,发出统计
    setTimeout(function () {
        $.get("ajax.php?action=gt5&aid=<?=$aid?>");
    },5000);
</script>
</body>
</html>
