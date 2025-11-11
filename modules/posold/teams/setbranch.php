<?php
session_start();

require_once("../../../lib.php");

$obj=(object)$_POST;


  $shpbranches=$_SESSION['shpbranches'];

  $num = count($shpbranches);

  if($obj->checked){
    $shpbranches[$num]=$obj->id;
  }

  $_SESSION['shpbranches']=$shpbranches;

?>
