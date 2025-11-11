<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employees_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../auth/users/Users_class.php");

$sys = $_GET['sys'];

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employeestatuss/Employeestatuss_class.php");
require_once("../../hrm/employeebanks/Employeebanks_class.php");
require_once("../../hrm/bankbranches/Bankbranches_class.php");
require_once("../../hrm/nationalitys/Nationalitys_class.php");
require_once("../../hrm/countys/Countys_class.php");
require_once("../../hrm/assignments/Assignments_class.php");
require_once("../../hrm/grades/Grades_class.php");
require_once("../../hrm/documents/Documents_class.php");
require_once ("../../sys/config/Config_class.php");
require_once ("../../sys/modules/Modules_class.php");
require_once("../../dms/categorys/Categorys_class.php");
require_once("../../dms/departmentcategorys/Departmentcategorys_class.php");
require_once("../../dms/departments/Departments_class.php");
require_once("../../dms/documentss/Documentss_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1163";//Edit
}
else{
	$auth->roleid="1161";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../hrm/employeeallowances/Employeeallowances_class.php");
require_once("../../hrm/allowances/Allowances_class.php");
require_once("../../hrm/allowancetypes/Allowancetypes_class.php");

//Process delete of employeeallowances
if(!empty($_GET['employeeallowances'])){
	$employeeallowances = new Employeeallowances();
	$employeeallowances->id=$_GET['employeeallowances'];
	$employeeallowances->delete($employeeallowances);
}
require_once("../../hrm/employeedependants/Employeedependants_class.php");

//Process delete of employeedependants
if(!empty($_GET['employeedependants'])){
	$employeedependants = new Employeedependants();
	$employeedependants->id=$_GET['employeedependants'];
	$employeedependants->delete($employeedependants);
}
require_once("../../hrm/employeedocuments/Employeedocuments_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");

require_once("../../hrm/employeesurchages/Employeesurchages_class.php");
require_once("../../hrm/surchagetypes/Surchagetypes_class.php");
require_once("../../hrm/surchages/Surchages_class.php");

//Process delete of employeesurchages
if(!empty($_GET['employeesurchages'])){
	$employeesurchages = new Employeesurchages();
	$employeesurchages->id=$_GET['employeesurchages'];
	$employeesurchages->delete($employeesurchages);
}

require_once("../../hrm/employeeloans/Employeeloans_class.php");
require_once("../../hrm/loans/Loans_class.php");

//Process delete of employeeloans
if(!empty($_GET['employeeloans'])){
	$employeeloans = new Employeeloans();
	$employeeloans->id=$_GET['employeeloans'];
	$employeeloans->delete($employeeloans);
}

//Process delete of employeedocuments
if(!empty($_GET['employeedocuments'])){
	$employeedocuments = new Employeedocuments();
	$employeedocuments->id=$_GET['employeedocuments'];
	
	$employeedoc = new Employeedocuments();
	$fields="*";
	$where=" where id='$employeedocuments->id'";
	$having="";
	$orderby="";
	$groupby="";
	$employeedoc->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$employeedoc = $employeedoc->fetchObject;
	
	unlink("documents/".$employeedoc->file);
	
	$employeedocuments->delete($employeedocuments);
}
require_once("../../hrm/employeequalifications/Employeequalifications_class.php");
require_once("../../hrm/qualifications/Qualifications_class.php");
require_once("../../hrm/gradings/Gradings_class.php");

//Process delete of employeequalifications
if(!empty($_GET['employeequalifications'])){
	$employeequalifications = new Employeequalifications();
	$employeequalifications->id=$_GET['employeequalifications'];
	$employeequalifications->delete($employeequalifications);
}
require_once("../../hrm/employeecontracts/Employeecontracts_class.php");
require_once("../../hrm/contracttypes/Contracttypes_class.php");

//Process delete of employeescontracts
if(!empty($_GET['employeecontracts'])){
	$employeecontracts = new Employeecontracts();
	$employeecontracts->id=$_GET['employeecontracts'];
	$employeecontracts->delete($employeecontracts);
}
require_once("../../hrm/employeeinsurances/Employeeinsurances_class.php");
require_once("../../hrm/insurances/Insurances_class.php");

//Process delete of employeeinsurances
if(!empty($_GET['employeeinsurances'])){
	$employeeinsurances = new Employeeinsurances();
	$employeeinsurances->id=$_GET['employeeinsurances'];
	$employeeinsurances->delete($employeeinsurances);
}

require_once("../../hrm/employeedeductions/Employeedeductions_class.php");
require_once("../../hrm/employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../../hrm/deductions/Deductions_class.php");
require_once("../../hrm/deductiontypes/Deductiontypes_class.php");

//Process delete of employeedeductions
if(!empty($_GET['employeedeductions'])){
	$employeedeductions = new Employeedeductions();
	$employeedeductions->id=$_GET['employeedeductions'];
	$employeedeductions->delete($employeedeductions);
}


require_once("../../hrm/employeedisplinarys/Employeedisplinarys_class.php");
require_once("../../hrm/disciplinarytypes/Disciplinarytypes_class.php");

//Process delete of employeedisplinarys
if(!empty($_GET['employeedisplinarys'])){
	$employeedisplinarys = new Employeedisplinarys();
	$employeedisplinarys->id=$_GET['employeedisplinarys'];
	$employeedisplinarys->delete($employeedisplinarys);
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
	

if($obj->action=="New Employee"){
	redirect("addemployees_proc.php");
}
if($obj->action=="Cancel"){
	redirect("employees.php?sys=true");
}
	
if($obj->action=="Save"){
	$employees=new Employees();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		
		$file=$_FILES['image']['tmp_name'];
		$filename=$_FILES['image']['name'];
		
		if(!empty($obj->oldimage))
			unlink("photos/".$obj->oldimage);
		
	if(!empty($filename)){
			$temp = explode(".", $filename);
			$num = count($temp);
						
			$obj->image=$obj->pfnum.".".$temp[$num-1];
		}
		
		$employees=$employees->setObject($obj);
		if($employees->add($employees)){
						
			if(!empty($filename)){
				copy($file, "photos/".$obj->image);
				
				img_resize( $file , 200 , "photos/" , $obj->image);
				
			}
			
			//create a user account
			$user = new Users();
			$user->employeeid=$employees->id;
			$user->username=$employees->firstname;
			if(!empty($employees->idno))
				$user->setPassword($employees->idno);
			elseif (empty($employees->idno) and !empty($employees->passportno))
				$user->setPassword($employees->passportno);
			$user->status="Active";
			$user->levelid=4;
			$user->createdby=$_SESSION['userid'];
			$user->createdon=date("Y-m-d H:i:s");
			$user->lasteditedby=$_SESSION['userid'];
			$user->lasteditedon=date("Y-m-d H:i:s");
			
			$user->add($user);
			
			$error=SUCCESS;
			redirect("addemployees_proc.php?error=".$error."&sys=".$obj->sys);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employees=new Employees();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		
		$file=$_FILES['image']['tmp_name'];
		$filename=$_FILES['image']['name'];
		
		if(!empty($obj->oldimage) and $obj->sys==false and !empty($filename))
			unlink("photos/".$obj->oldimage);
		echo $obj->oldimage;
		if(!empty($filename)){
			$temp = explode(".", $filename);
			$num = count($temp);
			
			$obj->image=$obj->pfnum.".".$temp[$num-1];
		}
		elseif(empty($filename) and !empty($obj->oldimage))
			$obj->image=$obj->oldimage;
		
		$employees=$employees->setObject($obj);
		if($employees->edit($employees)){
			
require_once("../../sys/config/Config_class.php");
require_once("../../sys/modules/Modules_class.php");
// require_once("../../sys/deductions/Deductions_class.php");			
		if(!empty($filename)){
		    //create a resource folder
			    $config = new Config();
			    $fields="";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $config=$config->fetchObject;
			    
			    //get module name
			    $module = new Modules();
			    $fields="";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $where=" where id=2 ";
			    $module->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $module=$module->fetchObject;
			    
			    @mkdir($config->DMS_RESOURCE."".$module->name);
			    @mkdir($config->DMS_RESOURCE."".$module->name."/photos");
				copy($file, $config->DMS_RESOURCE."".$module->name."/photos/".$obj->image);
				
				img_resize( $file , 200 , $config->DMS_RESOURCE."".$module->name."photos/" , $obj->image);
				
			}
			
			$error=UPDATESUCCESS;
			redirect("addemployees_proc.php?error=".$error."&sys=".$obj->sys);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of employeeallowances
if($obj->action=="Add Employeeallowance"){
	$employeeallowances = new Employeeallowances();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->amount=$obj->employeeallowancesamount;
	$ob->remarks=$obj->employeeallowancesremarks;
	$ob->allowanceid=$obj->employeeallowancesallowanceid;
	$ob->allowancetypeid=$obj->employeeallowancesallowancetypeid;
	$ob->frommonth=$obj->employeeallowancesfrommonth;
	$ob->fromyear=$obj->employeeallowancesfromyear;
	$ob->toyear=$obj->employeeallowancestoyear;
	$ob->tomonth=$obj->employeeallowancestomonth;

	$error=$employeeallowances->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeallowances->setObject($ob);

		if($employeeallowances->add($employeeallowances)){
			$obj->employeeallowancesamount="";
			$obj->employeeallowancesremarks="";
			$obj->employeeallowancesallowanceid="";
			$obj->employeeallowancesallowancetypeid="";
			$obj->employeeallowancesfrommonth="";
			$obj->employeeallowancesfromyear="";
			$obj->employeeallowancestoyear="";
			$obj->employeeallowancestomonth="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys."#tabs-7");
}


//Process adding of employeedependants
if($obj->action=="Add Employeedependant"){
	$employeedependants = new Employeedependants();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->name=$obj->employeedependantsname;
	$ob->dob=$obj->employeedependantsdob;
	$ob->relationship=$obj->employeedependantsrelationship;
	$ob->email=$obj->employeedependantsemail;
	$ob->mobile=$obj->employeedependantsmobile;

	$error=$employeedependants->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedependants->setObject($ob);

		if($employeedependants->add($employeedependants)){
			$obj->employeedependantsname="";
			$obj->employeedependantsdob="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys."#tabs-2");
}


//Process adding of employeedocuments
if($obj->action=="Add Employeedocument"){
	$employeedocuments = new Employeedocuments();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->documenttypeid=$obj->employeedocumentsdocumentid;
	$ob->file=$_FILES['employeedocumentsfile']['name'];
	$ob->remarks=$obj->employeedocumentsremarks;

	$error=$employeedocuments->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		
		$file=$_FILES['employeedocumentsfile']['tmp_name'];
		$filename=$_FILES['employeedocumentsfile']['name'];
		
		if(!empty($filename)){
			$temp = explode(".", $filename);
			$num = count($temp);
			
			$documenttypes = new Documenttypes();
			$where=" where id='$ob->documenttypeid' ";
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$documenttypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$documents = $documenttypes->fetchObject;
			
			$employeedocument = new Employeedocuments();
			$where=" where documenttypeid='$ob->documenttypeid' and employeeid='$obj->employeeid'";
			$fields=" (count(*) +1) id";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$employeedocument->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$employeedocument = $employeedocument->fetchObject;				
			
			
			//create a resource folder
			$config = new Config();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where name='DMS_RESOURCE'";
			$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$config=$config->fetchObject;
			
			$employees = new Employees();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id='$obj->employeeid'";
			$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$employees=$employees->fetchObject;
			
			$ob->document=$employees->pfnum." - ".$documents->name." - ".$employeedocument->id.".".$temp[$num-1];
			
			
			//get module name
			$module = new Modules();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id=2 ";
			$module->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$module=$module->fetchObject;
			
			$documenttypes=new Documenttypes();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id='$obj->employeedocumentsdocumentid' ";
			$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$documenttypes=$documenttypes->fetchObject;
			
			
			$ob->departmentid=2;
			$ob->departmentcategoryid=2;
			$ob->extras=$employees->pfnum;
			$ob->file=$file;
			$ob->filename=$filename;
			$ob->employeeid = $employees->id;
			
			$docs = new Documentss();
			$obs = $docs->setObject($ob);
			if(empty($obs->routeid))
			  $obs->routeid='NULL';
			if($docs->add($obs,$file,$filename)){			    
			  $ob->file=$ob->document;
			 // $documents->setObject($ob);
			//print_r($ob);
			$employeedocuments = $employeedocuments->setObject($ob);

			if($employeedocuments->add($employeedocuments)){
				
				
				    
				
				$obj->employeedocumentsdocumentid="";
				$obj->employeedocumentsfile="";
				$obj->employeedocumentsremarks="";
				$error=SUCCESS;
			}else{
				$error=FAILURE;
			}
	}
  }
  }
	redirect("addemployees_proc.php?id=".$obj->employeeid."&error=".$error."&sys=".$obj->sys."#tabs-3");
}

if($obj->action=="Filter Deductions"){
  $_SESSION['obj']=$obj;
  redirect("addemployees_proc.php?id=".$obj->employeeid."&error=".$error."&sys=true&filter=1#tabs-12");
}



//Process adding of employeequalifications
if($obj->action=="Add Employeequalification"){
	$employeequalifications = new Employeequalifications();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->qualificationid=$obj->employeequalificationsqualificationid;
	$ob->title=$obj->employeequalificationstitle;
	$ob->remarks=$obj->employeequalificationsremarks;
	$ob->gradingid=$obj->employeequalificationsgradingid;
	$ob->institution=$obj->employeequalificationsinstitution;

	$error=$employeequalifications->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeequalifications->setObject($ob);

		if($employeequalifications->add($employeequalifications)){
			$obj->employeequalificationsqualificationid="";
			$obj->employeequalificationstitle="";
			$obj->employeequalificationsremarks="";
			$obj->employeequalificationsgradingid="";
			$obj->employeequalificationsinstitution="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys."#tabs-4");
}


//Process adding of employeescontracts
if($obj->action=="Add Employeecontract"){
	$employeecontracts = new Employeecontracts();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->contracttypeid=$obj->employeecontractscontracttypeid;
	$ob->startdate=$obj->employeecontractsstartdate;
	$ob->confirmationdate=$obj->employeecontractsconfirmationdate;
	$ob->probation=$obj->employeecontractsprobation;
	$ob->contractperiod=$obj->employeecontractscontractperiod;
	$ob->status=$obj->employeecontractsstatus;
	$ob->remarks=$obj->employeecontractsremarks;

	$error=$employeecontracts->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeecontracts->setObject($ob);

		if($employeecontracts->add($employeecontracts)){
			$obj->employeecontractscontracttypeid="";
			$obj->employeecontractsstartdate="";
			$obj->employeecontractsconfirmationdate="";
			$obj->employeecontractsprobation="";
			$obj->employeecontractscontractperiod="";
			$obj->employeecontractsstatus="";
			$obj->employeecontractsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys."#tabs-5");
}


//Process adding of employeeinsurances
if($obj->action=="Add Employeeinsurance"){
	$employeeinsurances = new Employeeinsurances();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->insuranceid=$obj->employeeinsurancesinsuranceid;
	$ob->premium=$obj->employeeinsurancespremium;
	$ob->relief=$obj->employeeinsurancesrelief;
	$ob->startdate=$obj->employeeinsurancesstartdate;
	$ob->expectedenddate=$obj->employeeinsurancesexpectedenddate;
	$ob->remarks=$obj->employeeinsurancesremarks;

	$error=$employeeinsurances->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeinsurances->setObject($ob);

		if($employeeinsurances->add($employeeinsurances)){
			$obj->employeeinsurancesinsuranceid="";
			$obj->employeeinsurancespremium="";
			$obj->employeeinsurancesrelief="";
			$obj->employeeinsurancesstartdate="";
			$obj->employeeinsurancesexpectedenddate="";
			$obj->employeeinsurancesremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys."#tabs-6");
}

//Process adding of employeedeductions
if($obj->action=="Add Employeededuction"){
	$employeedeductions = new Employeedeductions();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->deductionid=$obj->employeedeductionsdeductionid;
	$ob->deductiontypeid=$obj->employeedeductionsdeductiontypeid;
	$ob->amount=$obj->employeedeductionsamount;
	$ob->type=$obj->employeedeductionstype;
	$ob->frommonth=$obj->employeedeductionsfrommonth;
	$ob->fromyear=$obj->employeedeductionsfromyear;
	$ob->tomonth=$obj->employeedeductionstomonth;
	$ob->toyear=$obj->employeedeductionstoyear;

	$error=$employeedeductions->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedeductions->setObject($ob);

		if($employeedeductions->add($employeedeductions)){
			$obj->employeedeductionsdeductionid="";
			$obj->employeedeductionsamount="";
			$obj->employeedeductionstype="";
			$obj->employeedeductionsfrommonth="";
			$obj->employeedeductionsfromyear="";
			$obj->employeedeductionstomonth="";
			$obj->employeedeductionstoyear="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys."#tabs-8");
}

//Process adding of employeeloans
if($obj->action=="Add Employeeloan"){
	$employeeloans = new Employeeloans();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->loanid=$obj->employeeloansloanid;
	$ob->principal=$obj->employeeloansprincipal;
	$ob->method=$obj->employeeloansmethod;
	$ob->initialvalue=$obj->employeeloansinitialvalue;
	$ob->payable=$obj->employeeloanspayable;
	$ob->duration=$obj->employeeloansduration;
	$ob->interesttype=$obj->employeeloansinteresttype;
	$ob->interest=$obj->employeeloansinterest;
	$ob->month=$obj->employeeloansmonth;
	$ob->year=$obj->employeeloansyear;

	$error=$employeeloans->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeloans->setObject($ob);

		if($employeeloans->add($employeeloans)){
			$obj->employeeloansloanid="";
			$obj->employeeloansprincipal="";
			$obj->employeeloansmethod="";
			$obj->employeeloansinitialvalue="";
			$obj->employeeloanspayable="";
			$obj->employeeloansduration="";
			$obj->employeeloansinterest="";
			$obj->employeeloansmonth="";
			$obj->employeeloansyear="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys."#tabs-10");
}

//Process adding of employeesurchages
if($obj->action=="Add Employeesurchage"){
	$employeesurchages = new Employeesurchages();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->surchageid=$obj->employeesurchagessurchageid;
	$ob->amount=$obj->employeesurchagesamount;
	$ob->chargedon=$obj->employeesurchageschargedon;
	$ob->frommonth=$obj->employeesurchagesfrommonth;
	$ob->fromyear=$obj->employeesurchagesfromyear;
	$ob->tomonth=$obj->employeesurchagestomonth;
	$ob->toyear=$obj->employeesurchagestoyear;
	$ob->remarks=$obj->employeesurchagesremarks;
	$ob->surchagetypeid=$obj->employeesurchagessurchagetypeid;

	$error=$employeesurchages->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeesurchages->setObject($ob);

		if($employeesurchages->add($employeesurchages)){
			$obj->employeesurchagessurchageid="";
			$obj->employeesurchagesamount="";
			$obj->employeesurchageschargedon="";
			$obj->employeesurchagesfrommonth="";
			$obj->employeesurchagesfromyear="";
			$obj->employeesurchagestomonth="";
			$obj->employeesurchagestoyear="";
			$obj->employeesurchagesremarks="";
			$obj->employeesurchagessurchagetypeid="";
			$error=SUCCESS;
		}else{echo mysql_error();
			$error=FAILURE;
		}
	}
	//redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys);
}

//Process adding of employeedisplinarys
if($obj->action=="Add Employeedisplinary"){
	$employeedisplinarys = new Employeedisplinarys();

	$ob->employeeid=$obj->employeeid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->disciplinarytypeid=$obj->employeedisplinarysdisciplinarytypeid;
	$ob->disciplinarydate=$obj->employeedisplinarysdisciplinarydate;
	$ob->description=$obj->employeedisplinarysdescription;
	$ob->remarks=$obj->employeedisplinarysremarks;

	$error=$employeedisplinarys->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedisplinarys->setObject($ob);

		if($employeedisplinarys->add($employeedisplinarys)){
			$obj->employeedisplinarysdisciplinarytypeid="";
			$obj->employeedisplinarysdisciplinarydate="";
			$obj->employeedisplinarysdescription="";
			$obj->employeedisplinarysremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addemployees_proc.php?id=".$obj->id."&error=".$error."&sys=".$obj->sys."#tabs-10");
}

if(empty($obj->action)){

	$employeestatuss= new Employeestatuss();
	$fields="hrm_employeestatuss.id, hrm_employeestatuss.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$banks= new Employeebanks();
	$fields="hrm_employeebanks.id, hrm_employeebanks.code, hrm_employeebanks.name, hrm_employeebanks.remarks, hrm_employeebanks.createdby, hrm_employeebanks.createdon, hrm_employeebanks.lasteditedby, hrm_employeebanks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$bankbranches= new Bankbranches();
	$fields="hrm_bankbranches.id, hrm_bankbranches.name, hrm_bankbranches.employeebankid, hrm_bankbranches.remarks, hrm_bankbranches.createdby, hrm_bankbranches.createdon, hrm_bankbranches.lasteditedby, hrm_bankbranches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$bankbranches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	$nationalitys= new Nationalitys();
	$fields="hrm_nationalitys.id, hrm_nationalitys.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nationalitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$countys= new Countys();
	$fields="hrm_countys.id, hrm_countys.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$countys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$assignments= new Assignments();
	$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_assignments.departmentid, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employees=new Employees();
	$where=" where id=$id ";
	$fields="hrm_employees.id, hrm_employees.type, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employees->fetchObject;
	
	$obj->employeeid=$obj->id;

	//for autocompletes
}
if($sys){
	$obj->sys=$sys;
}

if($ob->filter==1){
  $v = $_SESSION['obj'];
  $obj->employeepaiddeductionid=$v->employeepaiddeductionid;
  $obj->employeepaiddeductionmonth=$v->employeepaiddeductionmonth;
  $obj->employeepaiddeductionyear=$v->employeepaiddeductionyear;
}

if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		
		$employees = new Employees();
		$fields=" (max(id)+1) pfnum ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$oj=$employees->fetchObject;
		if(empty($oj->pfnum))
			$oj->pfnum=1;
		
		$oj->pfnum = str_pad($oj->pfnum, 3, 0, STR_PAD_LEFT);
		
		$obj->pfnum="HR".$oj->pfnum;
		
		$obj->statusid=1;
		
		$obj->action="Save";
		
	}
	else{
		$obj=$_SESSION['obj'];
	}
	
	
  
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
	
}
	
// if(empty($ob->filter)){echo "XX";
//   $obj->employeepaiddeductionmonth=date("m");
//   $obj->employeepaiddeductionyear=date("Y");
// }

$page_title="Employees ";
include "addemployees.php";
?>