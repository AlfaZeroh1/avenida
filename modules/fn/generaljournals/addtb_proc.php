<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../generaljournalaccounts/Generaljournalaccounts_class.php");

//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$id=$_GET['id'];
$error=$_GET['error'];
	
	
if($obj->action=="Update"){
	
	if(empty($obj->accountid)){
	  $error="Must provide Account!";
	}else{
	  $query="update tb set accountid='$obj->accountid' where id='$obj->id'";
	  if(mysql_query($query)){
		  $error="SUCCESS";
		  redirect("addtb_proc.php?id=".($obj->id+1));
	  }
	  else{
		$error="FAILURE";
	  }
	}
}

if(!empty($id)){
	$query = "select * from tb where id='$id'";
	
	$obj=mysql_fetch_object(mysql_query($query));

	//for autocompletes
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields=" * ";
	$where=" where id='$obj->accountid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$generaljournalaccounts->fetchObject;

	$obj->accountname=$auto->name;
}


if(empty($id) and empty($obj->action) and empty($obj->retrieve)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif((!empty($id) and empty($obj->action)) or !empty($obj->retrieve)){
	$obj->action="Update";
}
	
	
$page_title="Trial Balance ";
include "addtb.php";
?>