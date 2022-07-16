<?php
$file="test.txt"; //文件路径

$redisconfig=array(
    "host" => '127.0.0.1', // string 服务地址
    "port" => 6379,        // int    端口号
    "time" => 30,          // int    链接时长 (可选,默认为0,不限链接时间)
    "pass" => null,        // string redis密码（没有设置请输入null）
);

$keys="QWERTYUIOPASDFGHJKLZXCVBNM";//1234567890qwertyuiopasdfghjklzxcvbnm
$str=substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).'/'.substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).'/'.$file;
    
$redis = new Redis();
# 设置Redis参数
$redis->connect($redisconfig["host"], $redisconfig["port"], $redisconfig["time"]);
$redis->auth($redisconfig["pass"]);
$redis->setex($str, 86400, $file); 
# 86400是有效期，单位：秒

echo $str;