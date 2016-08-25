<?php
include 'redis_config.php';
include 'arrayToJSON.php';

$redis->DELETE($key);

?>