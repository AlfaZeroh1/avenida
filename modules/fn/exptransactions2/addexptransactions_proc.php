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
require_once("../../fn/liabilitys/Liabilitys_class.php");
// require_once("../../assets/assets/Assets_class.php");
require_once("../../inv/assets/Assets_class.php");
require_once("../../sys/purchasemodes/Purchasemodes_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once '../../sys/paymentmodes/Paymentmodes_class.php';
require_once '../../fn/banks/Banks_class.php';
require_once '../../fn/cashrequisitions/Cashrequisitions_class.php';
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
require_once("../../fn/imprests/Imprests_class.php");

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
$raise=$_GET['raise'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}

if(!empty($obj->invoiceno)){
  $obj->documentno=$obj->invoiceno;
  $obj->action="Filter";
}

if(!empty($raise))
{
	$currencys = new Currencys();
	$fields="*";
	$join=" ";
	$where=" where id='5' ";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $currencys->sql;
	$currencys=$currencys->fetchObject;
	$obj->currencyid=$currencys->id;
	$obj->currencyname=$currencys->name;
	$obj->exchangerate=$currencys->rate;
	$obj->exchangerate2=$currencys->eurorate;
	$obj->invoiceno=$ob->documentno;
	
	$obj->action="Raise";
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
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$exptransactions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$exptransactions=$exptransactions->setObject($obj);
		$shpexptransactions=$_SESSION['shpexptransactions'];
		if($exptransactions->edit($exptransactions,$shpexptransactions)){
			$error=UPDATESUCCESS;
			unset($_SESSION['shpexptransactions']);
			$saved="Yes";
			//redirect("addexptransactions_proc.php?id=".$exptransactions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){
        if(empty($obj->typeid)){
		$error="Type must be provided";
	}
	elseif($obj->typeid==1 and empty($obj->assetid)){
		$error="Asset must be provided";
	}
	elseif($obj->typeid==2 and empty($obj->expenseid)){
		$error="Expense must be provided";
	}
	elseif($obj->typeid==3 and empty($obj->liabilityid)){
		$error="Liability must be provided";
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
	
	$assets = new Assets();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->assetid'";
	$assets->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$assets=$assets->fetchObject;
	
	$liabilitys = new Liabilitys();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->liabilityid'";
	$liabilitys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$liabilitys=$liabilitys->fetchObject;
	
	$vatclasses = new Vatclasses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->vatclasseid'";
	$vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$vatclasses=$vatclasses->fetchObject;

	$obj->amount=$obj->amount*$obj->quantity;
	$shpexptransactions[$it]=array('id'=>"$obj->id",'expenseid'=>"$obj->expenseid", 'expensename'=>"$expenses->name",'assetid'=>"$obj->assetid", 'assetname'=>"$assets->name",'liabilityid'=>"$obj->liabilityid", 'liabilityname'=>"$liabilitys->name", 'quantity'=>"$obj->quantity",'taxamount'=>"$obj->taxamount",'vatclasseid'=>"$obj->vatclasseid",'vatclassename'=>"$vatclasses->name", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->amount", 'memo'=>"$obj->memo", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpexptransactions']=$shpexptransactions;

	$obj->expensename="";
	$obj->expenseid="";
 	$obj->assetid="";
 	$obj->assetname="";
 	$obj->liabilityid="";
 	$obj->liabilityname="";
 	$obj->quantity="";
 	$obj->tax="";
 	$obj->typeid="";
 	$obj->vatclasseid="";
 	$obj->discount="";
 	$obj->amount="";
 	$obj->total="";
 	$obj->taxamount="";
 	$obj->memo="";
 	$obj->id="";
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
	
	$imprestaccounts= new Imprestaccounts();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$projects= new Projects();
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$exptransactions=new Exptransactions();
	$where=" where id=$id ";
	$fields="fn_exptransactions.id, fn_exptransactions.expenseid,fn_exptransactions.imprestaccountid, fn_exptransactions.projectid, fn_exptransactions.supplierid, fn_exptransactions.purchasemodeid, fn_exptransactions.quantity, fn_exptransactions.tax, fn_exptransactions.discount, fn_exptransactions.amount, fn_exptransactions.total, fn_exptransactions.expensedate, fn_exptransactions.paid, fn_exptransactions.remarks, fn_exptransactions.memo, fn_exptransactions.documentno, fn_exptransactions.ipaddress, fn_exptransactions.createdby, fn_exptransactions.createdon, fn_exptransactions.lasteditedby, fn_exptransactions.lasteditedon";
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

if($obj->action=="Filter"){
        $obj->action="Update";
	if(!empty($obj->documentno)){
		$exptransactions = new Exptransactions();
		$fields="fn_exptransactions.*,sys_vatclasses.name as vatclassename,fn_expenses.name as expensename,fn_liabilitys.name as liabilityname,inv_assets.name as assetname ";
		$join=" left join fn_expenses on fn_exptransactions.expenseid=fn_expenses.id left join proc_suppliers on fn_exptransactions.supplierid=proc_suppliers.id  left join sys_purchasemodes on fn_exptransactions.purchasemodeid=sys_purchasemodes.id  left join sys_paymentmodes on fn_exptransactions.paymentmodeid=sys_paymentmodes.id  left join fn_banks on fn_exptransactions.bankid=fn_banks.id left join sys_vatclasses on sys_vatclasses.id=fn_exptransactions.vatclasseid left join inv_assets on inv_assets.id=fn_exptransactions.assetid left join fn_liabilitys on fn_liabilitys.id=fn_exptransactions.liabilityid left join fn_imprestaccounts on fn_exptransactions.imprestaccountid=fn_imprestaccounts.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_exptransactions.documentno='$obj->documentno' ";
		$exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$exptransactions->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shpexptransactions[$it]=array('id'=>"$ob->id",'expenseid'=>"$ob->expenseid", 'expensename'=>"$ob->expensename",'assetid'=>"$ob->assetid", 'assetname'=>"$ob->assetname",'liabilityid'=>"$ob->liabilityid", 'liabilityname'=>"$ob->liabilityname", 'quantity'=>"$ob->quantity",'taxamount'=>"$ob->taxamount",'vatclasseid'=>"$ob->vatclasseid",'vatclassename'=>"$ob->vatclassename", 'tax'=>"$ob->tax", 'discount'=>"$ob->discount", 'amount'=>"$ob->amount", 'memo'=>"$ob->memo", 'total'=>"$ob->total");

			$it++;
		}

		$obj = (object) array_merge((array) $obj, (array) $ob);
		
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
		
		$obj->action="Update";
		$obj->iterator=$it;
		$_SESSION['obj']=$obj;
		$_SESSION['shpexptransactions']=$shpexptransactions;
	}
	$obj->expensename="";
	$obj->expenseid="";
 	$obj->assetid="";
 	$obj->assetname="";
 	$obj->liabilityid="";
 	$obj->liabilityname="";
 	$obj->quantity="";
 	$obj->tax="";
 	$obj->typeid="";
 	$obj->vatclasseid="";
 	$obj->discount="";
 	$obj->amount="";
 	$obj->total="";
 	$obj->taxamount="";
 	$obj->memo="";
 	$obj->id="";
}
if($obj->action=="Raise"){ 
        $obj->action="Save";
	if(!empty($ob->documentno)){
		$cashrequisitions = new Cashrequisitions();		
		$fields="fn_cashrequisitions.*,fn_cashrequisitiondetails.expenseid,fn_cashrequisitiondetails.quantity,fn_cashrequisitiondetails.amount,fn_cashrequisitiondetails.total,fn_expenses.name as expensename ";
		$join=" left join fn_cashrequisitiondetails on fn_cashrequisitiondetails.cashrequisitionid=fn_cashrequisitions.id left join fn_expenses on fn_expenses.id=fn_cashrequisitiondetails.expenseid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_cashrequisitions.documentno='$ob->documentno' ";
		$cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $cashrequisitions->sql;
		$res=$cashrequisitions->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shpexptransactions[$it]=array('id'=>"$ob->id",'expenseid'=>"$ob->expenseid", 'expensename'=>"$ob->expensename",'assetid'=>"$ob->assetid", 'assetname'=>"$ob->assetname",'liabilityid'=>"$ob->liabilityid", 'liabilityname'=>"$ob->liabilityname", 'quantity'=>"$ob->quantity",'taxamount'=>"$ob->taxamount",'vatclasseid'=>"$ob->vatclasseid",'vatclassename'=>"$ob->vatclassename", 'tax'=>"$ob->tax", 'discount'=>"$ob->discount", 'amount'=>"$ob->amount", 'memo'=>"$ob->memo", 'total'=>"$ob->total");

			$it++;
		}

		$obj = (object) array_merge((array) $obj, (array) $ob);
		
		$obj->iterator=$it;
		$obj->remarks='Cash Requisition # '.$ob->documentno;
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from fn_exptransactions"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;
		$obj->requisitionno=$ob->documentno;
		$obj->expensedate=date("Y-m-d");
	  
		$_SESSION['obj']=$obj;
		$_SESSION['shpexptransactions']=$shpexptransactions;
	}
	$obj->expensename="";
	$obj->expenseid="";
 	$obj->assetid="";
 	$obj->assetname="";
 	$obj->liabilityid="";
 	$obj->liabilityname="";
 	$obj->quantity="";
 	$obj->tax="";
 	$obj->typeid="";
 	$obj->vatclasseid="";
 	$obj->discount="";
 	$obj->amount="";
 	$obj->total="";
 	$obj->taxamount="";
 	$obj->memo="";
 	$obj->id="";
}
if(empty($id) and empty($obj->action) and empty($obj->retrieve)){
	if(empty($_GET['edit'])){
	$currencys = new Currencys();
	$fields="*";
	$join=" ";
	$where=" where id='5' ";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $currencys->sql;
	$currencys=$currencys->fetchObject;
	$obj->currencyid=$currencys->id;
	$obj->currencyname=$currencys->name;
	$obj->exchangerate=$currencys->rate;
	$obj->exchangerate2=$currencys->eurorate;
	
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from fn_exptransactions"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;
		$obj->action="Save";
		
		$obj->expensedate=date("Y-m-d");
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action) or !empty($obj->retrieve)){
	$obj->action="Update";
}
	
	
$page_title="Exptransactions ";
include "addexptransactions.php";
?>
