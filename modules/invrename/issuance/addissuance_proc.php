<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Issuance_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/departments/Departments_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../inv/issuancedetails/Issuancedetails_class.php");
require_once("../../prod/blocks/Blocks_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../prod/sections/Sections_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");
require_once("../../assets/fleets/Fleets_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4772";//Edit
}
else{
	$auth->roleid="4770";//Add
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
	$obj->action="Filter";
}

if(!empty($ob->documentno)){
  $obj->invoiceno=$ob->documentno;
}

if($obj->action=="Save"){
	$issuance=new Issuance();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpissuance=$_SESSION['shpissuance'];
	$error=$issuance->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpissuance)){
		$error="No items in the sale list!";
	}
	else{
		$issuance=$issuance->setObject($obj);
		if($issuance->add($issuance,$shpissuance)){
			$error=SUCCESS;
			unset($_SESSION['shpissuance']);
			$saved="Yes";
			//redirect("addissuance_proc.php?id=".$issuance->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

if($obj->action=="Effect Journals"){
	$issuance=new Issuance();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpissuance=$_SESSION['shpissuance'];
	$error=$issuance->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpissuance)){
		$error="No items in the sale list!";
	}
	else{
		$issuance=$issuance->setObject($obj);
		$issuance->effectjournals=1;
		if($issuance->add($issuance,$shpissuance)){
			$error=SUCCESS;
			unset($_SESSION['shpissuance']);
			$saved="Yes";
			//redirect("addissuance_proc.php?id=".$issuance->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$issuance=new Issuance();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$issuance->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$issuance=$issuance->setObject($obj);
		$shpissuance=$_SESSION['shpissuance'];
		if($issuance->edit($issuance,"",$shpissuance)){
			$error=UPDATESUCCESS;
			unset($_SESSION['shpissuance']);
			$saved="Yes";
			//redirect("addissuance_proc.php?id=".$issuance->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$issuance = new Issuance();
		$fields=" inv_issuance.issuedon, inv_issuance.id,inv_issuance.documentno,inv_issuance.requisitionno,inv_issuancedetails.itemid, inv_issuance.journals,inv_items.name itemname,inv_issuancedetails.purpose, inv_categorys.name category, inv_issuancedetails.quantity,inv_issuancedetails.costprice,inv_issuancedetails.total,inv_issuancedetails.purpose,inv_issuancedetails.remarks,prod_blocks.name blockname, prod_sections.name sectionname, prod_greenhouses.name greenhousename, assets_fleets.assetid fleetid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename,hrm_employees.id employeeid,hrm_departments.name as departmentname,inv_issuance.departmentid as departmentid";
		
		$join=" left join inv_issuancedetails on inv_issuancedetails.issuanceid=inv_issuance.id left join inv_items on inv_issuancedetails.itemid=inv_items.id left join hrm_employees on hrm_employees.id=inv_issuance.employeeid left join inv_unitofmeasures on inv_unitofmeasures.id=inv_items.unitofmeasureid left join prod_blocks on prod_blocks.id=inv_issuancedetails.blockid left join prod_sections on prod_sections.id=inv_issuancedetails.sectionid left join prod_greenhouses on prod_greenhouses.id=inv_issuancedetails.greenhouseid left join assets_fleets on assets_fleets.id=inv_issuancedetails.fleetid left join hrm_departments on hrm_departments.id=inv_issuance.departmentid left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
		
		$having="";
		$groupby="";
		$orderby="";
		$where=" where inv_issuance.documentno='$obj->invoiceno'";
		$issuance->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $issuance->sql;
		$res=$issuance->result;
		$it=0;
		while($row=mysql_fetch_object($res)){			
			$ob=$row;
			$shpissuance[$it]=array('id'=>"$ob->id",'documentno'=>"$ob->documentno",'costprice'=>"$ob->costprice",'total'=>"$ob->total", 'itemid'=>"$ob->itemid", 'itemname'=>"$ob->itemname", 'quantity'=>"$ob->quantity", 'blockname'=>"$ob->blockname", 'remarks'=>"$ob->remarks", 'purpose'=>"$ob->purpose", 'sectionname'=>"$ob->sectionname",'greenhousename'=>"$ob->greenhousename",'employeename'=>"$ob->employeename",'employeeid'=>"$ob->employeeid",'total'=>"$ob->total",'categoryid'=>"$ob->categoryid", 'categoryname'=>"$ob->category");

			$it++;
		}

		
		$obj = (object) array_merge((array) $obj, (array) $ob);
		
		$obj->remarks="";
		$obj->itemid="";
		$obj->itemname="";
		$obj->costprice="";
		$obj->total="";
		$obj->quantity="";
		$obj->requiredon="";
		 
		 
		$obj->iterator=$it;
		
		$obj->action="Update";
		unset($_SESSION['shpissuance']);
		$_SESSION['obj']=$obj;
		$_SESSION['shpissuance']=$shpissuance;
	}
}
if($obj->action2=="Add"){

	if(empty($obj->itemid)){
		$error="Item must be provided";
	}
	else if(($obj->quantity>$obj->available) and empty($obj->retrieve)){
			$error="Stock not available";
		}
	else if($obj->quantity<=0){
		$error="Incorrect quantity";
	}
	
	
	
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpissuance=$_SESSION['shpissuance'];

	$items = new Items();
	$fields=" inv_items.*, inv_categorys.name category ";
	$join=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
	$groupby="";
	$having="";
	$where=" where inv_items.id='$obj->itemid'";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $items->sql;
	$items=$items->fetchObject;
	
	$blocks = new Blocks();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->blockid'";
	$blocks->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$blocks=$blocks->fetchObject;
	
	$sections = new Sections();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->sectionid'";
	$sections->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$sections=$sections->fetchObject;
	
	$greenhouses = new Greenhouses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->greenhouseid'";
	$greenhouses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$greenhouses=$greenhouses->fetchObject;
	
	$fleets = new Fleets();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->fleetid'";
	$fleets->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$fleets=$fleets->fetchObject;

	;
	$shpissuance[$it]=array('quantity'=>"$obj->quantity", 'costprice'=>"$obj->costprice", 'remarks'=>"$obj->remarks", 'itemid'=>"$obj->itemid", 'itemname'=>"$items->name", 'code'=>"$obj->code", 'total'=>"$obj->total", 'purpose'=>"$obj->purpose",'blockid'=>"$obj->blockid",'sectionid'=>"$obj->sectionid",'greenhouseid'=>"$obj->greenhouseid",'fleetid'=>"$obj->fleetid",'blockname'=>"$blocks->name",'sectionname'=>"$sections->name",'greenhousename'=>"$greenhouses->name",'fleetname'=>"$fleets->assetid", 'categoryid'=>"$items->categoryid",'categoryname'=>"$items->category");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpissuance']=$shpissuance;

	$obj->quantity="";
 	$obj->remarks="";
 	$obj->itemname="";
 	$obj->itemid="";
 	$obj->code="";
 	$obj->total=0;
}
}

if(empty($obj->action)){

	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$departments= new Departments();
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$issuance=new Issuance();
	$where=" where id=$id ";
	$fields="inv_issuance.id, inv_issuance.itemid, inv_issuance.departmentid, inv_issuance.employeeid, inv_issuance.quantity, inv_issuance.issuedon, inv_issuance.documentno, inv_issuance.remarks, inv_issuance.memo, inv_issuance.received, inv_issuance.receivedon, inv_issuance.createdby, inv_issuance.createdon, inv_issuance.lasteditedby, inv_issuance.lasteditedon, inv_issuance.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$issuance->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$issuance->fetchObject;

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
	$departments = new Departments();
	$fields=" * ";
	$where=" where id='$obj->departmentid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$departments->fetchObject;

	$obj->departmentname=$auto->name;
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

if(empty($obj->retrieve)){
  if(empty($_GET['edit'])){
       if(empty($obj->action) and empty($obj->action2)){
        $obj->issuedon=date('Y-m-d');

	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from inv_issuance"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;
      }
      $obj->action="Save";
  } 
  else{
    $obj=$_SESSION['obj'];
  }
  
}
else{  
    $obj->action="Update";
}

if($ob->raise==1){
      $obj = $_SESSION['ob'];
      $obj->action="Save";  
      $obj->issuedon=date('Y-m-d');
      $query="select (max(documentno)+1) documentno from inv_issuance";//echo $query;
      $defs=mysql_fetch_object(mysql_query($query));
         if($defs->documentno == null){
		$defs->documentno=1;
		}
      $obj->documentno=$defs->documentno;  
}
	

$page_title="Issuance ";
include "addissuance.php";
?>