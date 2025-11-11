<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Exptransactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/expenses/Expenses_class.php");
require_once("../../sys/purchasemodes/Purchasemodes_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once '../../sys/paymentmodes/Paymentmodes_class.php';
require_once '../../fn/banks/Banks_class.php';
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
require_once("../../em/plots/Plots_class.php");
require_once("../../inv/items/Items_class.php");
require_once ("../../inv/stocktrack/Stocktrack_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="753";//Edit
}
else{
	$auth->roleid="751";//Add
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
	$exptransactions=new Exptransactions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpexptransactions=$_SESSION['shpexptransactions'];
	$error=$exptransactions->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpexptransactions)){
		$error="No items in the sale list!";
	}
	else{
		$exptransactions=$exptransactions->setObject($obj);
		if($exptransactions->add($exptransactions,$shpexptransactions)){
			$error=SUCCESS;
			unset($_SESSION['shpexptransactions']);
			$saved="Yes";			
			//redirect("addexptransactions_proc.php?id=".$exptransactions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$exptransactions=new Exptransactions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$shpexptransactions=$_SESSION['shpexptransactions'];
	$error=$exptransactions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$exptransactions=$exptransactions->setObject($obj);
		if($exptransactions->edit($exptransactions,'',$shpexptransactions)){
			$error=SUCCESS;
			unset($_SESSION['shpexptransactions']);
			$saved="Yes";
			
			//redirect("addexptransactions_proc.php?id=".$exptransactions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->expenseid) and empty($obj->itemid)){
		$error="Either Expense/Item must be provided";
	}
	else if(!empty($obj->expenseid) and !empty($obj->itemid)){
		$error="Either Expense/Item must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpexptransactions=$_SESSION['shpexptransactions'];

	$expenses = new Expenses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->expenseid'";
	$expenses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$expenses=$expenses->fetchObject;
	
	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->expenseid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;
	
	$plots = new Plots();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->plotid'";
	$plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$plots=$plots->fetchObject;
	
	$paymentterms = new Paymentterms();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->paymenttermid'";
	$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$paymentterms=$paymentterms->fetchObject;

	;
	$shpexptransactions[$it]=array('expenseid'=>"$obj->expenseid", 'expensename'=>"$expenses->name",'itemid'=>"$obj->itemid",'itemname'=>"$obj->itemname",'plotid'=>"$obj->plotid",'plotname'=>"$plots->name",'paymenttermid'=>"$obj->paymenttermid" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$obj->quantity", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->amount", 'memo'=>"$obj->memo", 'total'=>"$obj->total",'month'=>"$obj->month",'year'=>"$obj->year");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpexptransactions']=$shpexptransactions;

	$obj->expensename="";
 	$obj->expenseid="";
 	$obj->itemname="";
 	$obj->itemid="";
 	$obj->quantity="";
 	$obj->tax="";
 	$obj->discount="";
 	$obj->plotid="";
 	$obj->paymenttermid='';
 	$obj->plotname="";
 	$obj->amount="";
 	$obj->memo="";
 }
}
if($obj->action2=="Filter"){
	if(!empty($obj->invoiceno)){
	$_SESSION['shpexptransactions']="";
		$exptransactions = new Exptransactions();
		$fields="fn_exptransactions.id, fn_exptransactions.voucherno, fn_exptransactions.itemid, inv_items.name as itemname, fn_expenses.name as expensename, fn_expenses.id expenseid, em_plots.name as plotname, em_plots.id plotid, em_paymentterms.name as paymenttermname, em_paymentterms.id paymenttermid, proc_suppliers.name as suppliername, proc_suppliers.id supplierid, sys_purchasemodes.id as purchasemodeid, fn_exptransactions.quantity, fn_exptransactions.tax, fn_exptransactions.discount, fn_exptransactions.amount, fn_exptransactions.total, fn_exptransactions.expensedate, fn_exptransactions.month, fn_exptransactions.year, fn_exptransactions.paid, fn_exptransactions.remarks, fn_exptransactions.memo, fn_exptransactions.documentno, sys_paymentmodes.id as paymentmodeid, fn_banks.id as bankid, fn_imprestaccounts.name as imprestaccountid, fn_exptransactions.chequeno, fn_exptransactions.ipaddress, fn_exptransactions.createdby, fn_exptransactions.createdon, fn_exptransactions.lasteditedby, fn_exptransactions.lasteditedon";
		$join=" left join fn_expenses on fn_exptransactions.expenseid=fn_expenses.id  left join em_plots on fn_exptransactions.plotid=em_plots.id  left join em_paymentterms on fn_exptransactions.paymenttermid=em_paymentterms.id  left join proc_suppliers on fn_exptransactions.supplierid=proc_suppliers.id  left join sys_purchasemodes on fn_exptransactions.purchasemodeid=sys_purchasemodes.id  left join sys_paymentmodes on fn_exptransactions.paymentmodeid=sys_paymentmodes.id  left join fn_banks on fn_exptransactions.bankid=fn_banks.id  left join fn_imprestaccounts on fn_exptransactions.imprestaccountid=fn_imprestaccounts.id left join inv_items on inv_items.id=fn_exptransactions.itemid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where voucherno='$obj->invoiceno' ";
		$exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$exptransactions->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shpexptransactions[$it]=array('expenseid'=>"$row->expenseid", 'expensename'=>"$row->expensename",'itemid'=>"$row->itemid", 'itemname'=>"$row->itemname",'plotid'=>"$row->plotid",'plotname'=>"$row->plotname",'paymenttermid'=>"$row->paymenttermid" ,'paymenttermname'=>"$row->paymenttermname", 'quantity'=>"$row->quantity", 'tax'=>"$row->tax", 'discount'=>"$row->discount", 'amount'=>"$row->amount", 'memo'=>"$row->memo", 'total'=>"$row->total",'month'=>"$row->month",'year'=>"$row->year");

			$it++;
		}

		$obj = (object) array_merge((array) $obj, (array) $ob);
		
		$obj->action="Update";

		$obj->iterator=$it;
		$_SESSION['shpexptransactions']=$shpexptransactions;
	}
}

if(empty($obj->action)){

	$expenses= new Expenses();
	$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$purchasemodes= new Purchasemodes();
	$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$exptransactions=new Exptransactions();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$exptransactions->fetchObject;

	//for autocompletes
	$suppliers = new Suppliers();
	$fields=" * ";
	$where=" where id='$obj->supplierid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$suppliers->fetchObject;

	$obj->suppliername=$auto->name;
	$projects = new Projects();
	$fields=" * ";
	$where=" where id='$obj->projectid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$projects->fetchObject;

	$obj->projectname=$auto->name;
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit']) and empty($obj->retrieve)){
		$obj->action="Save";
		$obj->month=date("m");
		$obj->year=date("Y");
		$obj->expensedate=date("Y-m-d");
		
		$rw = mysql_fetch_object(mysql_query("select (max(voucherno)+1) voucherno from fn_exptransactions"));
		if(empty($rw->voucherno))
		  $rw->voucherno=1;
		$obj->voucherno=$rw->voucherno;
	}
	else{
		$ob = str_replace("'","\"",$_GET['obj']);
		$ob = str_replace("\\","",$ob);
		$ob = unserialize($ob);
		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj->action="Update";
	}
	if(empty($obj->action2))
		$_SESSION['shpexptransactions']="";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Exptransactions ";
include "addexptransactions.php";
?>