<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotexpenses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/plots/Plots_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once "../../fn/generaljournalaccounts/Generaljournalaccounts_class.php";
require_once "../../fn/generaljournals/Generaljournals_class.php";
require_once "../../fn/imprestaccounts/Imprestaccounts_class.php";
require_once "../../em/paymentterms/Paymentterms_class.php";

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4356";//Edit
}
else{
	$auth->roleid="4354";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->retrieve))
  $obj->retrieve=$ob->retrieve;
  
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

	
}
	
if($obj->action=="Save"){
	$plotexpenses=new Plotexpenses();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpplotexpenses=$_SESSION['shpplotexpenses'];
	$error=$plotexpenses->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpplotexpenses)){
		$error="No items in the sale list!";
	}
	else{
		$plotexpenses=$plotexpenses->setObject($obj);
		$plotexpenses->plotname=$obj->plotname;
		$plotexpenses->ttotal=$obj->ttotal;
		if($plotexpenses->add($plotexpenses,$shpplotexpenses)){
			$error=SUCCESS;
			$saved="Yes";
			//redirect("addplotexpenses_proc.php?id=".$plotexpenses->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$plotexpenses=new Plotexpenses();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$plotexpenses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotexpenses=$plotexpenses->setObject($obj);
		$shpplotexpenses=$_SESSION['shpplotexpenses'];
		
		$plotexpenses->plotname=$obj->plotname;
		$plotexpenses->ttotal=$obj->ttotal;
		if($plotexpenses->edit($plotexpenses,"",$shpplotexpenses)){
			$error=UPDATESUCCESS;
			
			$saved="Yes";
			//redirect("addplotexpenses_proc.php?id=".$plotexpenses->id."&error=".$error);
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
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpplotexpenses=$_SESSION['shpplotexpenses'];

	$expenses = new Expenses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->expenseid'";
	$expenses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$expenses=$expenses->fetchObject;

	;
	$shpplotexpenses[$it]=array('expenseid'=>"$obj->expenseid", 'expensename'=>"$expenses->name", 'quantity'=>"$obj->quantity", 'amount'=>"$obj->amount", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpplotexpenses']=$shpplotexpenses;

	$obj->expensename="";
 	$obj->expenseid="";
 	$obj->quantity="";
 	$obj->amount="";
 	$obj->remarks="";
 }
}

if(empty($obj->action)){

	$plots= new Plots();
	$fields="em_plots.id, em_plots.code, em_plots.landlordid, em_plots.actionid, em_plots.noofhouses, em_plots.regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_plots.typeid, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, em_plots.employeeid, em_plots.deposit, em_plots.depositmgtfee, em_plots.depositmgtfeeperc, em_plots.depositmgtfeevatable, em_plots.depositmgtfeevatclasseid, em_plots.mgtfeevatclasseid, em_plots.vatable, em_plots.vatclasseid, em_plots.deductcommission, em_plots.status, em_plots.penaltydate, em_plots.paydate, em_plots.remarks, em_plots.photo, em_plots.longitude, em_plots.latitude, em_plots.ipaddress, em_plots.createdby, em_plots.createdon, em_plots.lasteditedby, em_plots.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$expenses= new Expenses();
	$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$banks= new Banks();
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$plotexpenses=new Plotexpenses();
	$where=" where id=$id ";
	$fields="em_plotexpenses.id, em_plotexpenses.plotid, em_plotexpenses.expenseid, em_plotexpenses.quantity, em_plotexpenses.amount, em_plotexpenses.total, em_plotexpenses.expensedate, em_plotexpenses.documentno, em_plotexpenses.month, em_plotexpenses.year, em_plotexpenses.paymentmodeid, em_plotexpenses.bankid, em_plotexpenses.chequeno, em_plotexpenses.remarks, em_plotexpenses.ipaddress, em_plotexpenses.createdby, em_plotexpenses.createdon, em_plotexpenses.lasteditedby, em_plotexpenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plotexpenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$plotexpenses->fetchObject;

	//for autocompletes
	$plots = new Plots();
	$fields=" * ";
	$where=" where id='$obj->plotid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$plots->fetchObject;

	$obj->plotname=$auto->name;
}


if($obj->action2=="Filter"){
	if(!empty($obj->voucherno)){
		$plotexpenses = new Plotexpenses();
		$fields="em_plotexpenses.id, em_plots.id as plotid, fn_expenses.id as expenseid, fn_expenses.name expensename, em_plotexpenses.quantity, em_plotexpenses.amount, em_plotexpenses.total, em_plotexpenses.expensedate, em_plotexpenses.documentno, em_plotexpenses.month, em_plotexpenses.year, sys_paymentmodes.id as paymentmodeid, fn_banks.id as bankid, em_plotexpenses.imprestaccountid, em_plotexpenses.chequeno, em_plotexpenses.remarks, em_plotexpenses.ipaddress, em_plotexpenses.createdby, em_plotexpenses.createdon, em_plotexpenses.lasteditedby, em_plotexpenses.lasteditedon";
		$join=" left join em_plots on em_plotexpenses.plotid=em_plots.id  left join fn_expenses on em_plotexpenses.expenseid=fn_expenses.id  left join sys_paymentmodes on em_plotexpenses.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_plotexpenses.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->voucherno' ";
		$plotexpenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plotexpenses->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shpplotexpenses[$it]=array('expenseid'=>"$row->expenseid", 'expensename'=>"$row->expensename", 'quantity'=>"$row->quantity", 'amount'=>"$row->amount", 'remarks'=>"$row->remarks", 'total'=>"$row->total");

			$it++;
		}

		//for autocompletes
		$plots = new Plots();
		$fields=" * ";
		$where=" where id='$ob->plotid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto=$plots->fetchObject;
		$auto->plotname=$auto->code." ".$auto->name;

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);
		
		$obj->action="Update";

		$obj->iterator=$it;
		$_SESSION['shpplotexpenses']=$shpplotexpenses;
	}
}
	
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit']) and empty($obj->retrieve)){
		$obj->action="Save";
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from em_plotexpenses"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;
		
		$obj->expensedate=date("Y-m-d");

		$obj->month=date("m");

		$obj->year=date("Y");

	}
	else{
		$ob = str_replace("'","\"",$_GET['obj']);
		$ob = unserialize($ob);
		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj->action="Update";
	}
}	
elseif(!empty($id) and empty($obj->action) and empty($_GET['edit'])){
	$obj->action="Update";
}

$page_title="Plotexpenses ";
include "addplotexpenses.php";
?>