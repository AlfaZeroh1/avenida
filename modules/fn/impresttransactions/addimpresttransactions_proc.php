<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Impresttransactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../fn/imprests/Imprests_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8137";//Edit
}
else{
	$auth->roleid="8135";//Add
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
	
if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from fn_impresttransactions"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->enteredon=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$impresttransactions=new Impresttransactions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpimpresttransactions=$_SESSION['shpimpresttransactions'];
	$error=$impresttransactions->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpimpresttransactions)){
		$error="No items in the sale list!";
	}
	else{
		$impresttransactions=$impresttransactions->setObject($obj);
		if($impresttransactions->add($impresttransactions,$shpimpresttransactions)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$impresttransactions=new Impresttransactions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$impresttransactions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$impresttransactions=$impresttransactions->setObject($obj);
		$shpimpresttransactions=$_SESSION['shpimpresttransactions'];
		if($impresttransactions->edit($impresttransactions,$shpimpresttransactions)){
			$error=UPDATESUCCESS;
			redirect("addimpresttransactions_proc.php?id=".$impresttransactions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->expenseid)){
		$error="Expense must be provided";
	}
	elseif(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
	elseif(empty($obj->amount)){
		$error="Amount must be provided";
	}
	elseif(empty($obj->incurredon)){
		$error="Transaction Date must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpimpresttransactions=$_SESSION['shpimpresttransactions'];

	$expenses = new Expenses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->expenseid'";
	$expenses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$expenses=$expenses->fetchObject;

	;
	$shpimpresttransactions[$it]=array('expenseid'=>"$obj->expenseid", 'expensename'=>"$expenses->name", 'quantity'=>"$obj->quantity", 'amount'=>"$obj->amount", 'incurredon'=>"$obj->incurredon", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpimpresttransactions']=$shpimpresttransactions;

	$obj->expensename="";
 	$obj->expenseid="";
 	$obj->quantity="";
 	$obj->amount="";
 	$obj->incurredon="";
 	$obj->remarks="";
 }
}

if(empty($obj->action)){

	$imprestaccounts= new Imprestaccounts();
	$fields="fn_imprestaccounts.id, fn_imprestaccounts.name, fn_imprestaccounts.employeeid, fn_imprestaccounts.remarks, fn_imprestaccounts.ipaddress, fn_imprestaccounts.createdby, fn_imprestaccounts.createdon, fn_imprestaccounts.lasteditedby, fn_imprestaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$imprests= new Imprests();
	$fields="fn_imprests.id, fn_imprests.documentno, fn_imprests.paymentvoucherno, fn_imprests.imprestaccountid, fn_imprests.employeeid, fn_imprests.issuedon, fn_imprests.paymentmodeid, fn_imprests.bankid, fn_imprests.chequeno, fn_imprests.amount, fn_imprests.memo, fn_imprests.remarks, fn_imprests.ipaddress, fn_imprests.createdby, fn_imprests.createdon, fn_imprests.lasteditedby, fn_imprests.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprests->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$expenses= new Expenses();
	$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$impresttransactions=new Impresttransactions();
	$where=" where id=$id ";
	$fields="fn_impresttransactions.id, fn_impresttransactions.documentno, fn_impresttransactions.imprestaccountid, fn_impresttransactions.imprestid, fn_impresttransactions.memo, fn_impresttransactions.quantity, fn_impresttransactions.amount, fn_impresttransactions.incurredon, fn_impresttransactions.enteredon, fn_impresttransactions.remarks, fn_impresttransactions.status, fn_impresttransactions.ipaddress, fn_impresttransactions.createdby, fn_impresttransactions.createdon, fn_impresttransactions.lasteditedby, fn_impresttransactions.lasteditedon, fn_impresttransactions.expenseid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$impresttransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$impresttransactions->fetchObject;

	//for autocompletes
	$items = new Items();
	$fields=" * ";
	$where=" where id='$obj->itemid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$items->fetchObject;

	$obj->itemname=$auto->name;
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
	
	
$page_title="Impresttransactions ";
include "addimpresttransactions.php";
?>