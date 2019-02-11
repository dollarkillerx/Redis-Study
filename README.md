# Redis-Study
Redis Study


``` 
make && make PREFIX=/opt/redis install
```
> redis.conf
``` 
daemonize yes  #守护进程方式启动
/opt/app/redis/bin/redis-server /etc/redis-6379.conf

/opt/app/redis/bin/redis-cli -p 6379 shutdown
启动多个redus记得改pid

bind 127.0.0.1 192.168.12.13 
```

>php connect
``` 
https://pecl.php.net/package/redis
/www/server/php7/bin/phpize
./configure --with-php-config=/www/server/php7/bin/php-config
make && make install
php.ini
extension=redis.so

$redis = new Redis();
$redis->connect('127.0.0.1',6379);
//注意 防火墙 与IP绑定
```
### key-value型数据
| 命令 | 语法 |
| ------ | ------ |
| set | $redis->set('age',20) |
| get | $age = $redis->get('age') |
| del | $redis->del('age') |
| exists | $isAgeExist = $redis->exists('age') |
| setnx | $res = $redis->setnx('age',20) |
| 键名一般按照模块重大到小设计,以冒号分割,如libdata:citylist:1 |
| 举例:PV量统计|
exists是否存在
setnx if 键不存在则设置

>注释:
get 不存在的值返回false exists不存在的值返回0存在返回1  setnx 设置不存在成功返回1失败返回0 php返回true or false

>命名规范
``` 
$redis->set('user:age:1',20);
$redis->set('user:age:2',20);
$redis->set('user:age:3',20);
//user:userinfo:1
//libdata:citylist:1
//libdata:pv
```

``` 
$pvKey = 'libdata:pv';
if (!$redis->exists($pvKey)){
    $redis->set($pvKey,1);
}
$redis->incrBy($pvKey,1); #自增
```
### hash 型数据
| 命令 | 语法 |
| ------ | ------ |
| hset | $redis->hSet('dollarkiller',age',20) |
| hget | $age = $redis->hGet('dollarkiller','age') |
| hdel | $redis->hDel('dollarkiller','age') |
| hexists | $isAgeExist = $redis->hExists('dollarkiller','age') |
| hsetnx | $res = $redis->hSetnx('dollarkiller','age',20) |
| 缓存独立与数据库之外,并不是所有数据都要接受延迟 要时刻注意数据的一致性 |
| 举例:用户信息在redis中读写|
``` 
//$db = mysqli_connect()
//$db->query("UPDATE `user` SET `age`=21 WHERE `id`=1")
$redis->hset('user:a','age',21);
用户更改的数据库,更新缓存
```

### list 型数据 有序集合
| 命令 | 语法 |
| ------ | ------ |
| lset | $redis->lSet('list',1下标,4) |
| llen 返回长度| $len = $redis->lLet('list') |
| lrange 切片得到数据不更改数据 | $arr = $redis->lRange('testList',0从下标0,3拉取到下标3) |
| ltrim 保留剪切内容删除为选中内容 | $redis->lTrim('testlist',0从下标0,3拉取到下标3) |
| lpush头插入,rpush尾插入 | $redis->rPush('testList',1) |
| lpop,rpop | $res = $redis->lPop('testlist') |
| 举例:操作日志的记录与读取|
``` 
$redis->rPush($key,'管理员1登录');
$redis->rPush($key,'删除账号1');
$redis->rPush($key,'修改账号2');
$redis->rPush($key,'管理员1登出');
```

### set 型数据  无序集合
| 命令 | 语法 |
| ------ | ------ |
| sadd 添加| $redis->sAdd('testset','a) |
| smembers 返回数组中所有成员| $arr = $redis->sMembers('testset') |
| scard 返回集合的成员数量| $count = $redis->sCard('testset') |
| spop 随机删| $rand = $redis->sPop('testset') |
| sdiff 求两个集合的差集| $arr = $redis->sDiff('testset','testset2') |

### redis 缓存优化
批量写入
``` 
//        $redis->hSet($key,'tid',$tid);
//        $redis->hSet($key,'name',$name);
//        $redis->hSet($key,'count',$count);
        $redis->hMSet($key,[
            'tid'=>$tid,
            'name'=>$name,
            'count'=>$count
        ]);
```
### 消息队列
- 消息队列是消息的顺序集合
- 常用场景
    - 1. 应对流量峰值
    - 2. 异步处理(不定速的插入,生产和匀数的处理,消费)
    - 3. 解耦应用(不同的来源的生产和不同去向的消费) 
    
