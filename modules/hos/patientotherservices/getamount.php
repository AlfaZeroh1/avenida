<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../otherservices/Otherservices_class.php");

$id = $_GET['serviceid'];
	$otherservices=new Otherservices();
	$where=" where id='$id' ";
	$fields="hos_otherservices.id, hos_otherservices.name, hos_otherservices.charge, hos_otherservices.createdby, hos_otherservices.createdon, hos_otherservices.lasteditedby, hos_otherservices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$otherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$otherservices = $otherservices->fetchObject;
	echo $otherservices->charge;
	
?>