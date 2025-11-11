<?php
session_start();

$obj = (object)$_GET;

$shps=$_SESSION['shps'];

$i = array_search($obj->id,$shps);
if($obj->checked=="true"){
  if(empty($i))
    array_push($shps,$obj->id);
}
else
{
  unset($shps[$i]);
}

$_SESSION['shps']=$shps;

?>