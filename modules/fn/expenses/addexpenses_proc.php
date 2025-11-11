<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Expenses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/expensecategorys/Expensecategorys_class.php");
require_once("../../fn/expensetypes/Expensetypes_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="745";//Edit
}
else{
	$auth->roleid="743";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$expenses=new Expenses();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$expenses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$expenses=$expenses->setObject($obj);
		if($expenses->add($expenses)){

			$error=SUCCESS;
			redirect("addexpenses_proc.php?id=".$expenses->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$expenses=new Expenses();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$expenses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$expenses=$expenses->setObject($obj);
		if($expenses->edit($expenses)){

			//updating corresponding general journal account
			$name=$obj->name;
			$obj->name=$name." Expense ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$expenses->id;
			$obj->acctypeid=4;
			$generaljournalaccounts->setObject($obj);
			$upwhere=" refid='$expenses->id' and acctypeid='4' ";
			$generaljournalaccounts->edit($generaljournalaccounts,$upwhere);

			$obj->name=$name." Prepaid Expense ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$expenses->id;
			$obj->acctypeid=5;
			$generaljournalaccounts->setObject($obj);
			$upwhere=" refid='$expenses->id' and acctypeid='5' ";
			$generaljournalaccounts->edit($generaljournalaccounts,$upwhere);

			$obj->name=$name." Accrued Expense ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$expenses->id;
			$obj->acctypeid=6;
			$generaljournalaccounts->setObject($obj);
			$upwhere=" refid='$expenses->id' and acctypeid='6' ";
			$generaljournalaccounts->edit($generaljournalaccounts,$upwhere);

			$error=UPDATESUCCESS;
			redirect("addexpenses_proc.php?id=".$expenses->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$expensecategorys= new Expensecategorys();
	$fields="fn_expensecategorys.id, fn_expensecategorys.name, fn_expensecategorys.remarks, fn_expensecategorys.ipaddress, fn_expensecategorys.createdby, fn_expensecategorys.createdon, fn_expensecategorys.lasteditedby, fn_expensecategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expensecategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$expensetypes= new Expensetypes();
	$fields="fn_expensetypes.id, fn_expensetypes.name, fn_expensetypes.remarks, fn_expensetypes.ipaddress, fn_expensetypes.createdby, fn_expensetypes.createdon, fn_expensetypes.lasteditedby, fn_expensetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expensetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$expenses=new Expenses();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$expenses->fetchObject;
	
	$expensecategorys= new Expensecategorys();
	$fields="*";
	$join="";
	$where=" where id='$obj->expensecategoryid' ";
	$having="";
	$groupby="";
	$orderby="";
	$expensecategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$expensecategorys = $expensecategorys->fetchObject;
	
	$obj->expensetypeid=$expensecategorys->expensetypeid;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Expenses ";
include "addexpenses.php";
?>