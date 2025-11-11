<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Imprests_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8133";//Edit
}
else{
	$auth->roleid="8131";//Add
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
	$imprests=new Imprests();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpimprests=$_SESSION['shpimprests'];
	$error=$imprests->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpimprests)){
		$error="No items in the sale list!";
	}
	else{
		$imprests=$imprests->setObject($obj);
		if($imprests->add($imprests,$shpimprests)){
			$error=SUCCESS;
			unset($_SESSION['shpimprests']);
			//redirect("addimprests_proc.php?id=".$imprests->id."&error=".$error);
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$imprests=new Imprests();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$imprests->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$imprests=$imprests->setObject($obj);
		$shpimprests=$_SESSION['shpimprests'];
		if($imprests->edit($imprests,$where="",$shpimprests)){
			$error=UPDATESUCCESS;
			unset($_SESSION['shpimprests']);
			//redirect("addimprests_proc.php?id=".$imprests->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->imprestaccountid) and empty($obj->employeeid)){
		$error="Imprest Account/Employee must be provided";
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
	$shpimprests=$_SESSION['shpimprests'];

	$imprestaccounts = new Imprestaccounts();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->imprestaccountid'";
	$imprestaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$imprestaccounts=$imprestaccounts->fetchObject;
	
// 	$employees = new Employees();
// 	$fields=" concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name ";
// 	$join="";
// 	$groupby="";
// 	$having="";
// 	$where=" where id='$obj->employeeid'";
// 	$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 	$employees=$employees->fetchObject;
	
	$shpimprests[$it]=array('imprestaccountid'=>"$obj->imprestaccountid", 'imprestaccountname'=>"$imprestaccounts->name", 'employeeid'=>"$obj->employeeid", 'employeename'=>"$obj->employeename", 'amount'=>"$obj->amount", 'remarks'=>"$obj->remarks");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpimprests']=$shpimprests;

	$obj->imprestaccountname="";
 	$obj->imprestaccountid="";
 	$obj->total=0;
	$obj->amount="";
 	$obj->remarks="";
 }
}
if($obj->action=="Filter"){
	if(!empty($obj->invoiceno)){
		$shpimprests=array();
		$imprests = new Imprests();
		$fields="fn_imprests.*,concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) as employeename,fn_imprestaccounts.name as imprestaccountname";
		$join=" left join hrm_employees on hrm_employees.id=fn_imprests.employeeid left join fn_imprestaccounts on fn_imprestaccounts.id=fn_imprests.imprestaccountid  ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_imprests.documentno='$obj->invoiceno'";
		$imprests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$imprests->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shpimprests[$it]=array('imprestaccountid'=>"$row->imprestaccountid", 'imprestaccountname'=>"$row->imprestaccountname", 'employeeid'=>"$row->employeeid", 'employeename'=>"$row->employeename", 'amount'=>"$row->amount", 'remarks'=>"$row->remarks");

			$it++;
		}

		$obj = (object) array_merge((array) $obj, (array) $ob);

		$obj->iterator=$it;
		$obj->action="Update";
		$_SESSION['obj']=$obj;
		
		
		$_SESSION['shpimprests']=$shpimprests;
	}
	$obj->imprestaccountname="";
 	$obj->imprestaccountid="";
 	$obj->total=0;
	$obj->amount="";
 	$obj->remarks="";
}
if(empty($obj->action)){

	$imprestaccounts= new Imprestaccounts();
	$fields="fn_imprestaccounts.id, fn_imprestaccounts.name, fn_imprestaccounts.employeeid, fn_imprestaccounts.remarks, fn_imprestaccounts.ipaddress, fn_imprestaccounts.createdby, fn_imprestaccounts.createdon, fn_imprestaccounts.lasteditedby, fn_imprestaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


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
	$imprests=new Imprests();
	$where=" where id=$id ";
	$fields="fn_imprests.id, fn_imprests.documentno, fn_imprests.paymentvoucherno, fn_imprests.imprestaccountid, fn_imprests.employeeid, fn_imprests.issuedon, fn_imprests.paymentmodeid, fn_imprests.bankid, fn_imprests.chequeno, fn_imprests.amount, fn_imprests.memo, fn_imprests.remarks, fn_imprests.ipaddress, fn_imprests.createdby, fn_imprests.createdon, fn_imprests.lasteditedby, fn_imprests.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$imprests->fetchObject;

	//for autocompletes
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


if(empty($id) and empty($obj->action) and empty($obj->retrieve)){
	if(empty($_GET['edit'])){echo $_GET['edit'].'jjjjjjjj';
	
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
		
		if($ob->raise==1){
		  $obj = $_SESSION['ob'];
		}
		
		$obj->action="Save";
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from fn_imprests"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;
	$obj->paymentvoucherno=$defs->documentno;

	$obj->issuedon=date('Y-m-d');
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif((!empty($id) and empty($obj->action)) or !empty($obj->retrieve)){
	$obj->action="Update";
}
	
	
$page_title="Imprests ";
include "addimprests.php";
?>