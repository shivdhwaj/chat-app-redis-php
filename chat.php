<?php
include 'redis_config.php';
include 'arrayToJSON.php';
/*$data=$redis->LRANGE($key,0,10);
if(isset($data))
{
$data= $redis->LRANGE($key,0,10);
}
else
{
$redis->set($key, '');
}
*/

if(isset($_POST['content']) && isset($_POST['user']) )
{
if($redis && !empty($_POST['content']) &&  !empty($_POST['user']))
{
$message=$_POST['content'];
$user=$_POST['user'];
$time=date("c", time());
$redis->lpush($key, serialize(array($user,$time, $message)));
}
$data=$redis->LRANGE($key,0,30);
$newData = arrayToJSON($data);
echo $newData;
}
?>