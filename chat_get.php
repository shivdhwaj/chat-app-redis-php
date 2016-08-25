<?php
include 'redis_config.php';
include 'arrayToJSON.php';
if(isset($_POST['user']))
{
$data=$redis->LRANGE($key,0,30);
$newData = arrayToJSON($data);
echo $newData;
}
?>