<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: wangye-->
<!-- * Date: 19-2-12-->
<!-- * Time: 下午2:18-->
<!-- */-->
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>消息队列PV统计</title>
    <style>
        .a{
            text-align: center;
        }
    </style>
</head>
<body>
<div class="a">
    <h1>欢迎访问首页</h1>
    <?php
    /*
        //获取PV
        include_once './GetDb.php';
        $conn = GetDb::getInstance();
        $sql = "SELECT `value` FROM `test_tab` WHERE `name` = 'index'";
        $result = $conn->query($sql);
        $arr=$result->fetch(PDO::FETCH_ASSOC);
        $pv = $arr['value'];
    */

        #redis set方式实现
        include_once './GetRedis.php';
        $redis = GetRedis::getInstance();
        $key = "pv:index";
        $pv = $redis->get($key);
    ?>
    <p>当前PV量:<?php echo $pv ?></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<script>
    //给pv量加以
    $.get('addpv.php',()=>{});
</script>
</body>
</html>