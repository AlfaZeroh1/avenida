<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlords_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4129";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4127";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../em/plots/Plots_class.php");
require_once("../../em/actions/Actions_class.php");
require_once("../../em/regions/Regions_class.php");
require_once("../../em/types/Types_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../em/landlordemergencycontacts/Landlordemergencycontacts_class.php");

//Process delete of landlordemergencycontacts
if(!empty($_GET['landlordemergencycontacts'])){
	$landlordemergencycontacts = new Landlordemergencycontacts();
	$landlordemergencycontacts->id=$_GET['landlordemergencycontacts'];
	$landlordemergencycontacts->delete($landlordemergencycontacts);
}
require_once("../../em/landlorddocuments/Landlorddocuments_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");

//Process delete of landlorddocuments
if(!empty($_GET['landlorddocuments'])){
	$landlorddocuments = new Landlorddocuments();
	$landlorddocuments->id=$_GET['landlorddocuments'];
	$landlorddocuments->delete($landlorddocuments);
}
//Process delete of plots
if(!empty($_GET['plots'])){
	$id=$_GET['plots'];
	$plots=new Plots();
	$where=" where id=$id ";
	$fields="em_plots.id, em_plots.code, em_plots.landlordid, em_plots.penaltydate, em_plots.actionid, em_plots.noofhouses, em_plots.regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_plots.typeid, em_plots.commissiontype, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, em_plots.employeeid, em_plots.deposit, em_plots.vatable, em_plots.status, em_plots.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$plots=$plots->fetchObject;
	
	$plot=new Plots();
	$plot->edit($plots);
}


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
	
if($obj->action=="Save"){
	$landlords=new Landlords();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$landlords->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlords=$landlords->setObject($obj);
		if($landlords->add($landlords)){
			
			//adding general journal account(s)
			$name=$obj->code." ".$obj->firstname." ".$obj->middlename." ".$obj->lastname;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$landlords->id;
			$obj->acctypeid=33;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$error=SUCCESS;
			redirect("addlandlords_proc.php?id=".$landlords->id."&error=".$error."#tabs-1");
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$landlords=new Landlords();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$landlords->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlords=$landlords->setObject($obj);
		if($landlords->edit($landlords)){
			
			//updating corresponding general journal account
			$name=$obj->firstname." ".$obj->middlename." ".$obj->lastname;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$landlords->id;
			$obj->acctypeid=33;
			$generaljournalaccounts->setObject($obj);
			$upwhere=" refid='$landlords->id' and acctypeid='30' ";
			$generaljournalaccounts->edit($generaljournalaccounts,$upwhere);
			
			$error=UPDATESUCCESS;
			redirect("addlandlords_proc.php?id=".$landlords->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of plots
if($obj->action=="Add Plot"){
	$plots = new Plots();

	$ob->landlordid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->code=$obj->plotscode;
	$ob->estate=$obj->plotsestate;
	$ob->road=$obj->plotsroad;
	$ob->location=$obj->plotslocation;
	$ob->letarea=$obj->plotsletarea;
	$ob->unusedarea=$obj->plotsunusedarea;
	$ob->employeeid=$obj->plotsemployeeid;
	$ob->deposit=$obj->plotsdeposit;
	$ob->vatable=$obj->plotsvatable;
	$ob->status=$obj->plotsstatus;
	$ob->lrno=$obj->plotslrno;
	$ob->name=$obj->plotsname;
	$ob->actionid=$obj->plotsactionid;
	$ob->noofhouses=$obj->plotsnoofhouses;
	$ob->regionid=$obj->plotsregionid;
	$ob->managefrom=$obj->plotsmanagefrom;
	$ob->managefor=$obj->plotsmanagefor;
	$ob->indefinite=$obj->plotsindefinite;
	$ob->typeid=$obj->plotstypeid;
	$ob->commission=$obj->plotscommission;
	$ob->target=$obj->plotstarget;
	$ob->penaltydate=$obj->plotspenaltydate;
	$ob->paydate=$obj->plotspaydate;
	$ob->remarks=$obj->plotsremarks;

	$error=$plots->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plots->setObject($ob);

		if($plots->add($plots)){
			$obj->plotscode="";
			$obj->plotsestate="";
			$obj->plotsroad="";
			$obj->plotslocation="";
			$obj->plotsletarea="";
			$obj->plotsunusedarea="";
			$obj->plotsemployeeid="";
			$obj->plotsemployeename="";
			$obj->plotsdeposit="";
			$obj->plotsvatable="";
			$obj->plotsstatus="";
			$obj->plotslrno="";
			$obj->plotsname="";
			$obj->plotsactionid="";
			$obj->plotsnoofhouses="";
			$obj->plotsregionid="";
			$obj->plotsmanagefrom="";
			$obj->plotsmanagefor="";
			$obj->plotsindefinite="";
			$obj->plotstypeid="";
			$obj->plotscommission="";
			$obj->plotstarget="";
			$obj->plotsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addlandlords_proc.php?id=".$obj->id."&error=".$error."#tabs-2");
}

//Process adding of landlordemergencycontacts
if($obj->action=="Add Landlordemergencycontact"){
	$landlordemergencycontacts = new Landlordemergencycontacts();

	$ob->landlordid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->name=$obj->landlordemergencycontactsname;
	$ob->relation=$obj->landlordemergencycontactsrelation;
	$ob->tel=$obj->landlordemergencycontactstel;
	$ob->email=$obj->landlordemergencycontactsemail;
	$ob->address=$obj->landlordemergencycontactsaddress;
	$ob->physicaladdress=$obj->landlordemergencycontactsphysicaladdress;
	$ob->remarks=$obj->landlordemergencycontactsremarks;

	$error=$landlordemergencycontacts->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlordemergencycontacts->setObject($ob);

		if($landlordemergencycontacts->add($landlordemergencycontacts)){
			$obj->landlordemergencycontactsname="";
			$obj->landlordemergencycontactsrelation="";
			$obj->landlordemergencycontactstel="";
			$obj->landlordemergencycontactsemail="";
			$obj->landlordemergencycontactsaddress="";
			$obj->landlordemergencycontactsphysicaladdress="";
			$obj->landlordemergencycontactsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addlandlords_proc.php?id=".$obj->id."&error=".$error."#tabs-4");
}


//Process adding of landlorddocuments
if($obj->action=="Add Landlorddocument"){
	$landlorddocuments = new Landlorddocuments();

	$ob->landlordid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];


	$document=$_FILES['landlorddocumentsdocument']['tmp_name'];
	$documentname=$_FILES['landlorddocumentsdocument']['name'];
	$ob->document=$documentname;
	copy($document,"files/".$documentname);

	$ob->remarks=$obj->landlorddocumentsremarks;
	$ob->documenttypeid=$obj->landlorddocumentsdocumenttypeid;
	$ob->name=$obj->landlorddocumentsname;

	$error=$landlorddocuments->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlorddocuments->setObject($ob);

		if($landlorddocuments->add($landlorddocuments)){
			$obj->landlorddocumentsdocument="";
			$obj->landlorddocumentsremarks="";
			$obj->landlorddocumentsdocumenttypeid="";
			$obj->landlorddocumentsname="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addlandlords_proc.php?id=".$obj->id."&error=".$error."#tabs-3");
}

if(empty($obj->action)){
}

if(!empty($id)){
	$landlords=new Landlords();
	$where=" where id=$id ";
	$fields="em_landlords.id, em_landlords.llcode, em_landlords.firstname, em_landlords.middlename, em_landlords.lastname, em_landlords.tel, em_landlords.email, em_landlords.registeredon, em_landlords.fax, em_landlords.mobile, em_landlords.idno, em_landlords.passportno, em_landlords.postaladdress, em_landlords.address, em_landlords.status";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$landlords->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$landlords->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		
		$landlords = new Landlords();
		$fields=" (max(id)+1) code ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$landlords->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$ob=$landlords->fetchObject;
		if(empty($ob->code))
			$ob->code=1;
		
		$ob->code = str_pad($ob->code, 4, 0, STR_PAD_LEFT);
		
		$obj->llcode="L".$ob->code;
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->status="1";
}	
elseif(!empty($id) and empty($obj->action)){
	
	$plots = new Plots();
	$fields=" (max(id)+1) code ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $plots->sql;
	$oj=$plots->fetchObject;
	if(empty($oj->code))
		$oj->code=1;
	
	$oj->code = str_pad($oj->code, 4, 0, STR_PAD_LEFT);
	
	$obj->plotscode="PLT".$oj->code;echo $obj->plotscode;
	
	$obj->action="Update";
}
	
$page_title="Landlords ";
include "addlandlords.php";
?>