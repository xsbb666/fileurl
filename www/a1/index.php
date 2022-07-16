<?php
$uid=1; //自定义参数
$file="test.txt"; //文件路径
$fid=2; //自定义参数

$redisconfig=array(
    "host" => '127.0.0.1', // string 服务地址
    "port" => 6379,        // int    端口号
    "time" => 30,          // int    链接时长 (可选,默认为0,不限链接时间)
    "pass" => null,        // string redis密码（没有设置请输入null）
);

$keys="QWERTYUIOPASDFGHJKLZXCVBNM";//1234567890qwertyuiopasdfghjklzxcvbnm
$token=substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64).substr(str_shuffle($keys),mt_rand(0,strlen($keys)-11),64);

$str=$file.'?fid='.$fid."&fkey=".$token.'&uid='.$uid."&from=223";
    
$redis = new Redis();
# 设置Redis参数
$redis->connect($redisconfig["host"], $redisconfig["port"], $redisconfig["time"]);
$redis->auth($redisconfig["pass"]);
$redis->setex($str, 86400, $file); 
# 86400是有效期，单位：秒

echo $str;