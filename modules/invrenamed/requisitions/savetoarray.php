<?php
session_start();
require_once("../../../lib.php");

$obj=(object)$_GET;
          
        $shprequisitions=$_SESSION['shprequisitions'];
        
	$shprequisitions[$obj->i]['dquantity']=$obj->dquantity;
        
        $_SESSION['shprequisitions']=$shprequisitions;
       // print_r($shpdepartmentbudgets);
?>
