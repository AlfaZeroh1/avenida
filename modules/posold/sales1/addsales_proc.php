<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sales_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/agents/Agents_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hos/patients/Patients_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../hos/payments/Payments_class.php");
require_once '../../hos/payables/Payables_class.php';
require_once("../../hos/insurances/Insurances_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2206";//Edit
}
else{
	$auth->roleid="2204";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->mode))
		$obj->mode=$ob->mode;

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
	$defs=mysql_fetch_object(mysql_query("select max(documentno)+1 documentno from pos_sales where mode='$obj->mode'"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->soldon=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$sales=new Sales();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpsales=$_SESSION['shpsales'];
	$error=$sales->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpsales)){
		$error="No items in the sale list!";
	}
	else{
		$sales=$sales->setObject($obj);
		if($sales->add($sales,$shpsales)){
			$error=SUCCESS;
			$saved="Yes";
			//redirect("addsales_proc.php?&error=".$error."&mode=".$obj->mode);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$sales=new Sales();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$sales->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sales=$sales->setObject($obj);
		$shpsales=$_SESSION['shpsales'];
		if($sales->edit($sales,$shpsales)){

			//Make a journal entry

			//retrieve account to debit
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->customerid' and acctypeid='29'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;

			//retrieve account to credit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='1' and acctypeid='25'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
			$error=UPDATESUCCESS;
			$saved="Yes";
			//redirect("addsales_proc.php?id=".$sales->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
	elseif(empty($obj->itemid)){
		$error="Item must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpsales=$_SESSION['shpsales'];

	$items = new Items();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$items=$items->fetchObject;

	;
	$shpsales[$it]=array('quantity'=>"$obj->quantity", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'code'=>"$obj->code", 'stock'=>"$obj->stock", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'retailprice'=>"$obj->retailprice", 'tradeprice'=>"$obj->tradeprice", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpsales']=$shpsales;

	$obj->quantity="";
 	$obj->itemname="";
 	$obj->itemid="";
 	$obj->code="";
 	$obj->stock="";
 	$obj->tax="";
 	$obj->discount="";
 	$obj->retailprice="";
 	$obj->tradeprice="";
 	$obj->total=0;
}
}

if(empty($obj->action)){

	$agents= new Agents();
	$fields="crm_agents.id, crm_agents.name, crm_agents.address, crm_agents.tel, crm_agents.fax, crm_agents.email, crm_agents.statusid, crm_agents.remarks, crm_agents.createdby, crm_agents.createdon, crm_agents.lasteditedby, crm_agents.lasteditedon, crm_agents.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$patients= new Patients();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$sales=new Sales();
	$where=" where id=$id ";
	$fields="pos_sales.id, pos_sales.itemid, pos_sales.documentno, pos_sales.patientid, pos_sales.agentid, pos_sales.employeeid, pos_sales.remarks, pos_sales.quantity, pos_sales.costprice, pos_sales.tradeprice, pos_sales.retailprice, pos_sales.discount, pos_sales.tax, pos_sales.bonus, pos_sales.profit, pos_sales.total, pos_sales.mode, pos_sales.soldon, pos_sales.expirydate, pos_sales.memo, pos_sales.createdby, pos_sales.createdon, pos_sales.lasteditedby, pos_sales.lasteditedon, pos_sales.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sales->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$sales->fetchObject;

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
	$patients = new Patients();
	$fields=" * ";
	$where=" where id='$obj->patientid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$patients->fetchObject;

	$obj->patientname=$auto->name;
	$agents = new Agents();
	$fields=" * ";
	$where=" where id='$obj->agentid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$agents->fetchObject;

	$obj->agentname=$auto->name;
	$employees = new Employees();
	$fields=" * ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
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
	
	
$page_title="Sales ";
include "addsales.php";
?>