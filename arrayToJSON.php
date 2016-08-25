<?php
function arrayToJSON($arr)
{	
if(count($arr) > 0)
{		
for($i=0; $i<count($arr); $i++)
{
$data = @unserialize($arr[$i]);
if($data !== false )
{
$arr[$i] = unserialize($arr[$i]);	
}	
}
}
return json_encode($arr);
}
?>