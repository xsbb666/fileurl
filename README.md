# 临时文件外链

## 前言

你是否经常看到别人的文件URL是这样的：file.txt?a=xxx&b=xxx

访问file.txt需要传参数，这些参数是临时有效的

或者是这种URL：xxxxx/xxxxx/file.txt

这个文件URL是临时有效的
---

## 安装

### 安装

1.PHP(推荐PHP版本7.2)

2.redis

### PHP扩展
1.fileinfo

2.redis

### Nginx配置
请添加如下配置到Nginx的配置文件中
```
    error_page 404 = /file.php?$args;
    error_page 404 /file.php;
    error_page 403 /file.php;
    error_page 500 /file.php;
```
---

## 使用

通过创建Redis和随机字符串来生成一个临时文件外链，设置数据的有效期来达到临时访问文件的目的。


这个项目一共有两种文件外链

第一种：file.txt?a=xxx&b=xxx (在a1文件夹内)

第二种：xxxx/xxxx/file.txt (在a2文件夹内)

示例：这是一个创建test.txt的文件临时链接

A1
```
$str='text.txt?fid=1&fkey=123456789&uid=1&from=1';
//自定义参数，默认有fid、fkey、uid、from，如果需要自己自定义请修改file.php
$file='text.txt';
//文件路径

$redis = new Redis();
# 设置Redis参数
$redis->connect("127.0.0.1", 6379, 30); //服务地址、端口、连接时长
$redis->auth(null); //密码
$redis->setex($str, 86400, $file); 
# 86400是有效期，单位：秒

echo $str;
```

A2
```
$str='xxxxx/xxxxx/text.txt';
//自定义路径
$file='text.txt';
//文件路径

$redis = new Redis();
# 设置Redis参数
$redis->connect("127.0.0.1", 6379, 30); //服务地址、端口、连接时长
$redis->auth(null); //密码
$redis->setex($str, 86400, $file); 
# 86400是有效期，单位：秒

echo $str;
```