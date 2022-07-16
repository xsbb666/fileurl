<?php
// $http=explode("?",'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"])[0];

$http_file=explode("?",substr($_SERVER["REQUEST_URI"],1))[0];


$redisconfig=array(
    "host" => '127.0.0.1', // string 服务地址
    "port" => 6379,        // int    端口号
    "time" => 30,          // int    链接时长 (可选,默认为0,不限链接时间)
    "pass" => null,        // string redis密码（没有设置请输入null）
);

$redis = new redis();
$redis->connect($redisconfig["host"], $redisconfig["port"], $redisconfig["time"]);
$redis->auth($redisconfig["pass"]);
$file = $redis->get($http_file);
if(!$file)$file = $redis->get($file_path2);

if($file){$filepath='../upload/'.$file;}

if($file&&!is_dir($filepath)&&file_exists($filepath)) 
{
     header("Access-Control-Allow-Origin: *");
     GetMp4File('../upload/'.$filepath);
}
else if(!file_exists($filepath)&&$file)
{
	header('HTTP/1.1 404 not found');
}
else if(is_dir($filepath))
{
    header('HTTP/1.1 1 500 HTTP-Internal Server Error');
}
else
{
    header('HTTP/1.0 403 Forbidden');
}

function GetMp4File($file) { 
    $fi = new finfo(FILEINFO_MIME_TYPE); 
   $mime_type = $fi->file($file); 
    $size = filesize($file); 
    header("Content-type: ".$mime_type); 
    header("Accept-Ranges: bytes"); 
    if(isset($_SERVER['HTTP_RANGE'])){ 
        header("HTTP/1.1 206 Partial Content"); 
        list($name, $range) = explode("=", $_SERVER['HTTP_RANGE']); 
        list($begin, $end) =explode("-", $range); 
        if($end == 0){ 
            $end = $size - 1; 
        } 
    }else { 
        $begin = 0; $end = $size - 1; 
    } 
    header("Content-Length: " . ($end - $begin + 1)); 
    header("Content-Range: bytes ".$begin."-".$end."/".$size);
    $fp = fopen($file, 'rb'); 
    fseek($fp, $begin); 
    while(!feof($fp)) { 
        $p = min(1024, $end - $begin + 1); 
        $begin += $p; 
        echo fread($fp, $p); 
    } 
    fclose($fp); 
} 