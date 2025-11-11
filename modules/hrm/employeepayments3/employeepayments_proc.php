<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepayments_class.php");
require_once '../../hrm/employees/Employees_class.php';
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/employeebanks/Employeebanks_class.php");
require_once("../../hrm/allowances/Allowances_class.php");
require_once("../../hrm/employeeallowances/Employeeallowances_class.php");
require_once("../../hrm/employeedeductions/Employeedeductions_class.php");
require_once("../../hrm/employeepaidallowances/Employeepaidallowances_class.php");
require_once("../../hrm/employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../../hrm/deductions/Deductions_class.php");
require_once("../../hrm/payes/Payes_class.php");
require_once("../../hrm/reliefs/Reliefs_class.php");
require_once("../../hrm/employeereliefs/Employeereliefs_class.php");
require_once("../../hrm/nhifs/Nhifs_class.php");
require_once("../../hrm/nssfs/Nssfs_class.php");
require_once("../../hrm/loans/Loans_class.php");
require_once("../../hrm/configs/Configs_class.php");
require_once("../../hrm/employeeloans/Employeeloans_class.php");
require_once '../../hrm/surchages/Surchages_class.php';
require_once '../../hrm/employeesurchages/Employeesurchages_class.php';
require_once("../../hrm/departments/Departments_class.php");
require_once '../../sys/paymentmodes/Paymentmodes_class.php';
require_once '../../fn/banks/Banks_class.php';
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../hrm/employeearrears/Employeearrears_class.php");
require_once("../../hrm/employeepaidarrears/Employeepaidarrears_class.php");
require_once("../../hrm/employeeclockings/Employeeclockings_class.php");
require_once("../../hrm/arrears/Arrears_class.php");
require_once("../../hrm/overtimes/Overtimes_class.php");
require_once("../../hrm/employeeovertimes/Employeeovertimes_class.php");
require_once("../../hrm/employeepaidarrears/Employeepaidarrears_class.php");
require_once("../../hrm/employeepaidsurchages/Employeepaidsurchages_class.php");
require_once("../../hrm/employeedeductionexempt/Employeedeductionexempt_class.php");
require_once("../../sys/currencyrates/Currencyrates_class.php");

if(empty($_SESSION['userid'])){
	redirect("../../auth/users/login.php");
}

$page_title="Employeepayments";
//connect to db
$db=new DB();
$obj = (object)$_POST;

//Authorization.
$auth->roleid="4262";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

if(empty($obj->action)){
	$obj->month=date("m");
	$obj->year=date("Y");
	$obj->paidon=date('Y-m-d');
	
	$obj->fromdate= date("Y-m-1", mktime(0, 0, 0, $obj->month, 1, $obj->year));
	$obj->todate = date("Y-m-t", mktime(0, 0, 0, $obj->month, 1, $obj->year)); 
}
$delid=$_GET['delid'];
$employees=new Employees();
if(!empty($delid)){
	$employeepayments->id=$delid;
	$employeepayments->delete($employeepayments);
	redirect("employeepayments.php");
}

$wh=" ";
$i=0;
if(!empty($obj->action)){
	$inner=20;
// 	$inner=100;
// 	if($obj->allowances==1)
// 		$inner+=20;
// 	if($obj->deductions==1)
// 		$inner+=20;
	
	if(!empty($obj->bankid)){
		if($i>0)
			$wh.=" and ";
		else
			$wh.=" and ";
	
		$wh.=" hrm_employees.bankid='$obj->bankid' ";
		$i++;
	}
	
	if(!empty($obj->type)){
		if($i>0)
			$wh.=" and ";
		else
			$wh.=" and ";
	
		$wh.=" hrm_employees.type='$obj->type' ";
		$i++;
	}
	
	
	if(!empty($obj->departmentid)){
		if($i>0)
			$wh.=" and ";
		else
			$wh.=" and ";
	
		$wh.=" hrm_assignments.departmentid='$obj->departmentid' ";
		$jn=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		$i++;
	}
	
}
else{
	$inner=150;
}

if($obj->action=="Make Payment"){
	//get all employees and check whose check boxes are ticked
	$employees = new Employees();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hrm_employees.statusid=1 and hrm_employees.id not in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year')";
	$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);

	$gnallowances=array();
	$gnarrears=array();
	$gndeductions=array();
	$gnloans=array();
	$gnbankloans=array();
	$gninterests=array();
	$gnsalaries=array();
	$gnincomes=array();
	
	$gn=array();
	$x=0;
	$employeedeductionexempt=new Employeedeductionexempt();
	while($row=mysql_fetch_object($employees->result))
	{
		//check if checked
		if(!empty($_POST[$row->id])){
			//get basic
			$basic = $row->basic;
			$taxable=0;
				
			//get employee allowances
			$totalallowances = 0;
			$allowances=new Allowances();
			$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowancetypes.repeatafter, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
			$join=" left join hrm_allowancetypes on hrm_allowances.allowancetypeid=hrm_allowancetypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			//to ensure that the allowance is active
			$where=" where  hrm_allowances.status='active'";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($allowances->result)){
				$allowance=0;
				$now=getDates($obj->year, $obj->month, 01);
				//check allowances that affect all
				if($rw->overall=="All"){
					//check if the to date is reached
					$fromdate=getDates($rw->fromyear, $rw->frommonth, 01);
					$todate=getDates($rw->toyear, $rw->tomonth, 01);	
					if(!empty($rw->toyear) and !empty($rw->tomonth)){
					  if($now>=$fromdate and $now<=$todate){
							  //check frequency qualifier
							  $employeepaidallowances=new Employeepaidallowances();
							  $fields="hrm_employeepaidallowances.id, hrm_employeepayments.id employeepaymentid, hrm_employeepaidallowances.allowanceid, hrm_employeepaidallowances.employeeid, hrm_employeepaidallowances.amount, hrm_employeepaidallowances.month, hrm_employeepaidallowances.year, hrm_employeepaidallowances.createdby, hrm_employeepaidallowances.createdon, hrm_employeepaidallowances.lasteditedby, hrm_employeepaidallowances.lasteditedon";
							  $join=" left join hrm_employeepayments on hrm_employeepaidallowances.employeepaymentid=hrm_employeepayments.id ";
							  $where=" where hrm_employeepaidallowances.employeeid=$row->id and hrm_employeepaidallowances.allowanceid=$rw->id ";
							  $having="";
							  $groupby="";
							  $orderby=" order by hrm_employeepaidallowances.id desc";
							  $employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
							  $employeepaidallowances->fetchObject;
							  $next=getDates($employeepaidallowances->year, $employeepaidallowances->month+$row->repeatafter, 01);
							  if($next<=$now){
								  $allowance=$row->amount;
								  //$taxable+=($row->amount*$rw->percentaxable);
							  }
							  else{
								  $allowance=0;
							  }
					  }
					  else{
						  $allowance=0;
					  }
					}
					else{
					  $allowance=$row->amount;
					 // $taxable+=($row->amount*$rw->percentaxable);
					}
					
					$ob=$obj;
					$ob->allowanceid=$rw->id;
					$ob->employeeid=$row->id;
					$ob->amount=$allowance;
					$ob->createdby=$_SESSION['userid'];
					$ob->createdon=date("Y-m-d H:i:s");
					$ob->lasteditedby=$_SESSION['userid'];
					$ob->lasteditedon=date("Y-m-d H:i:s");
					$ob->ipaddress=$_SERVER['REMOTE_ADDR'];
					
					$employeepaidallowances->setObject($ob);
					
					$employeepaidallowances->add($employeepaidallowances);

					$totalallowances+=$allowance;
					$taxable+=($allowance*$rw->percentaxable);
					
					$gnallowances[$ob->allowanceid]+=$allowance;//echo print_r($gnallowances)."<br/>";
				}
				//check employee specific allowances
				else{
					if($rw->id==3){
					  //retrieve all overtimes
					  $overtimes = new Overtimes();
					  $fields="*";
					  $join=" ";
					  $where=" ";
					  $having="";
					  $groupby="";
					  $orderby="";
					  $overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					  while($ov=mysql_fetch_object($overtimes->result)){
					    $employeeovertimes = new Employeeovertimes();
					    $fields="sum(hours) hrs, sum(hours) hours";
					    $join=" ";
					    $where=" where overtimeid='$ov->id' and employeeid='$row->id' and month='$obj->month' and year='$obj->year' ";
					    $having="";
					    $groupby="";
					    $orderby="";
					    $employeeovertimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeeovertimes->sql;
					    $employeeovertimes = $employeeovertimes->fetchObject;
					    
					    $ob->overtimeid="";
					    if($employeeovertimes->hrs>0){
					      
					      $employeeovertimes->amount=($row->basic/ ($ov->hrs*52/12) *$ov->value)*$employeeovertimes->hrs;
					      
					      //$taxable+=$employeeovertimes->amount;
					      $allowance=$employeeovertimes->amount;
					      $ob=$obj;
					      $ob->allowanceid=$rw->id;
					      $ob->overtimeid=$ov->id;
					      $ob->hours=$employeeovertimes->hrs;
					      $ob->employeeid=$row->id;
					      $ob->amount=$allowance;
					      $ob->createdby=$_SESSION['userid'];
					      $ob->createdon=date("Y-m-d H:i:s");
					      $ob->lasteditedby=$_SESSION['userid'];
					      $ob->lasteditedon=date("Y-m-d H:i:s");
					      $ob->ipaddress=$_SERVER['REMOTE_ADDR'];
					      
					      $employeepaidallowances->setObject($ob);
					      
					      $employeepaidallowances->add($employeepaidallowances);

					      $totalallowances+=$allowance;
					      $taxable+=($allowance*$rw->percentaxable);
					      
					      $gnallowances[$ob->allowanceid]+=$allowance;//echo print_r($gnallowances)."<br/>";
					    }
					  }
					}else{
					  $employeeallowances=new Employeeallowances();
					  $fields="hrm_employeeallowances.id, hrm_allowances.name as allowanceid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_allowancetypes.name as allowancetypeid, hrm_employeeallowances.amount, hrm_employeeallowances.frommonth, hrm_employeeallowances.fromyear, hrm_employeeallowances.tomonth, hrm_employeeallowances.toyear, hrm_employeeallowances.remarks, hrm_employeeallowances.createdby, hrm_employeeallowances.createdon, hrm_employeeallowances.lasteditedby, hrm_employeeallowances.lasteditedon";
					  $join=" left join hrm_allowances on hrm_employeeallowances.allowanceid=hrm_allowances.id  left join hrm_employees on hrm_employeeallowances.employeeid=hrm_employees.id  left join hrm_allowancetypes on hrm_employeeallowances.allowancetypeid=hrm_allowancetypes.id ";
					  $having="";
					  $groupby="";
					  $orderby="";
					  //checks if allowance is still active
					  $where=" where hrm_employeeallowances.employeeid=$row->id and hrm_employeeallowances.allowanceid=$rw->id ";
					  if($rw->allowancetypeid==2){
					    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeeallowances.frommonth)),concat('-',hrm_employeeallowances.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeeallowances.tomonth)),concat('-',hrm_employeeallowances.toyear)),'%d-%m-%Y') ";
					  }
					  $employeeallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					  $employeeallowances = $employeeallowances->fetchObject;
					  
					  if(!empty($employeeallowances->tomonth) and !empty($employeeallowances->toyear)){
					    $start=getDates($employeeallowances->fromyear, $employeeallowances->frommonth, 01);
					    $todate=getDates($employeeallowances->toyear, $employeeallowances->tomonth, 01);
					    $next=getDates($employeeallowances->year, $employeeallowances->month+$rw->repeatafter, 01);
					    if($now>=$start and $now<=$todate and $next>=$now){
						    $allowance=$employeeallowances->amount;
						    //$taxable+=($employeeallowances->amount*$rw->percentaxable);
						     //if($row->id==276)echo $rw->id." == ".$employeeallowances->amount." == ".$rw->percentaxable."<br/>";
					    }
					    else{
						    $allowance=0;
					    }
					  }
					  else{
					    $allowance=$employeeallowances->amount;
					   
					    //$taxable+=($employeeallowances->amount*$rw->percentaxable);
					  }
					  $employeepaidallowances = new Employeepaidallowances();

					  $ob=$obj;
					  $ob->allowanceid=$rw->id;
					  $ob->employeeid=$row->id;
					  $ob->amount=$allowance;
					  $ob->createdby=$_SESSION['userid'];
					  $ob->createdon=date("Y-m-d H:i:s");
					  $ob->lasteditedby=$_SESSION['userid'];
					  $ob->lasteditedon=date("Y-m-d H:i:s");
					  $ob->ipaddress=$_SERVER['REMOTE_ADDR'];
					  
					  $employeepaidallowances->setObject($ob);
					  
					  $employeepaidallowances->add($employeepaidallowances);

					  $totalallowances+=$allowance;
					  $taxable+=($allowance*$rw->percentaxable);
					  
					  $gnallowances[$ob->allowanceid]+=$allowance;//echo print_r($gnallowances)."<br/>";
				      }
				}
					
				

			}
				
			$taxable+=$row->basic;		
			
			//$taxable=$gross;
			
			$taxablearrears = 0;
			$nontaxablearrears=0;
			//get payable arrears that are taxable
			$employeearrears = new Employeearrears();
			$fields="*";
			$join=" left join hrm_arrears on hrm_arrears.id=hrm_employeearrears.arrearid";
			$where=" where hrm_employeearrears.employeeid='$row->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
			$having="";
			$groupby="";
			$orderby="";
			$employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($sr = mysql_fetch_object($employeearrears->result)){
			  
			  $ob = $obj;
			  $ob->arrearid=$sr->arrearid;
			  $ob->employeeid=$sr->employeeid;
			  $ob->amount=$sr->amount;
			  echo $ob->amount;
			  $ob->createdby=$_SESSION['userid'];
			  $ob->createdon=date("Y-m-d H:i:s");
			  $ob->lasteditedby=$_SESSION['userid'];
			  $ob->lasteditedon=date("Y-m-d H:i:s");
			  $ob->ipaddress=$_SERVER['REMOTE_ADDR'];
			  
			  $employeepaidarrears = new Employeepaidarrears();
			  $employeepaidarrears = $employeepaidarrears->setObject($ob);
			  $employeepaidarrears->add($employeepaidarrears);
			  
			  //$gnarrears[$sr->arrearid]+=$sr->amount;
			  if($sr->taxable=="Yes")
			    $taxablearrears+=$sr->amount;
			  else
			    $nontaxablearrears+=$sr->amount;
			}
			
			$taxable+=$taxablearrears;
			$gross=$basic+$totalallowances;
			$grosspay=$basic+$totalallowances;
			$ob->loanid=0;
			
			//get deductions
			$totaldeductions = 0;
			$deductions=new Deductions();
			$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.amount, hrm_deductions.deductiontypeid, hrm_deductions.epays, hrm_deductiontypes.repeatafter, hrm_deductions.overall, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
			$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			//to ensure that the deduction is active
			$where=" where  hrm_deductions.status='active'";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($deductions->result)){
				$deduction=0;
				$ob->employeramount=0;
				$now=getDates($obj->year, $obj->month, 01);
				//check deductions that affect all
				if($rw->id==1){
					//get PAYE
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$row->id,$obj->month,$obj->year))
					{
					$payes = new Payes();
					//get NSSF
					$nssfs = new Nssfs();
					$taxable=$payes->getTaxable($taxable, $row->id, $obj);
					$deduction=$payes->getPAYE($taxable,$row->id, $obj);
					
					
					$employeepaiddeductions = new Employeepaiddeductions();

					$ob=$obj;
					$ob->deductionid=$rw->id;
					$ob->employeeid=$row->id;
					$ob->loanid='';
					$ob->reducing="Yes";
					$ob->amount=$deduction;
					$ob->createdby=$_SESSION['userid'];
					$ob->createdon=date("Y-m-d H:i:s");
					$ob->lasteditedby=$_SESSION['userid'];
					$ob->lasteditedon=date("Y-m-d H:i:s");
					$ob->ipaddress=$_SERVER['REMOTE_ADDR'];

					$employeepaiddeductions->setObject($ob);
					if($deduction!=0)
					  $employeepaiddeductions->add($employeepaiddeductions);

					$gndeductions[$ob->deductionid]+=$deduction;
					
					$totaldeductions+=$deduction;
					}
				}
				elseif ($rw->id==2){
					//get NHIF
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$row->id,$obj->month,$obj->year))
					{
					$nhifs = new Nhifs();
					$deduction=$nhifs->getNHIF($gross);
					
					$employeepaiddeductions = new Employeepaiddeductions();

					$ob=$obj;
					$ob->deductionid=$rw->id;
					$ob->employeeid=$row->id;
					$ob->loanid='';
					$ob->reducing="Yes";
					$ob->amount=$deduction;
					$ob->createdby=$_SESSION['userid'];
					$ob->createdon=date("Y-m-d H:i:s");
					$ob->lasteditedby=$_SESSION['userid'];
					$ob->lasteditedon=date("Y-m-d H:i:s");
					$ob->ipaddress=$_SERVER['REMOTE_ADDR'];

					$employeepaiddeductions->setObject($ob);
					if($deduction!=0)
					  $employeepaiddeductions->add($employeepaiddeductions);

					$gndeductions[$ob->deductionid]+=$deduction;
					
					$totaldeductions+=$deduction;
					}
				}
				elseif ($rw->id==3){
					//get NSSF
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$row->id,$obj->month,$obj->year))
					{
					$nssfs = new Nssfs();
					$deduction=$nssfs->getNSSF($gross);
					
					$employeepaiddeductions = new Employeepaiddeductions();

					$ob=$obj;
					$ob->deductionid=$rw->id;
					$ob->employeeid=$row->id;
					$ob->loanid='';
					$ob->reducing="Yes";
					$ob->amount=$deduction;
					$ob->employeramount=$deduction;
					$ob->createdby=$_SESSION['userid'];
					$ob->createdon=date("Y-m-d H:i:s");
					$ob->lasteditedby=$_SESSION['userid'];
					$ob->lasteditedon=date("Y-m-d H:i:s");
					$ob->ipaddress=$_SERVER['REMOTE_ADDR'];

					$employeepaiddeductions->setObject($ob);
					if($deduction!=0)
					  $employeepaiddeductions->add($employeepaiddeductions);

					$gndeductions[$ob->deductionid]+=$deduction;
					
					$totaldeductions+=$deduction;
					}
				}
				elseif($rw->id==4){
				  $loans = new Loans();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where="";
			$loans->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($wr=mysql_fetch_object($loans->result)){
				$employeeloans = new Employeeloans();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where employeeid='$row->id' and loanid='$wr->id' and principal>0";
				$employeeloans->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				if($employeeloans->affectedRows>0){
					$rw->loanid=0;
					
					while($rwf=mysql_fetch_object($employeeloans->result)){
						
						if($rwf->principal>$rwf->payable)
						  $deduction=$rwf->payable;
						else	
						  $deduction=$rwf->principal;
						$principal=$rwf->principal;
						$totaldeductions+=$deduction;
						$ob->loanid=0;
						$ob->amount=0;
						//if($obj->deductions==1){
							
								$employeepaiddeductions = new Employeepaiddeductions();

								$ob=$obj;
								$ob->deductionid=4;
								$ob->loanid=$wr->id;
								$ob->reducing="Yes";
								$ob->employeeid=$row->id;
								$ob->amount=$deduction;
								$ob->createdby=$_SESSION['userid'];
								$ob->createdon=date("Y-m-d H:i:s");
								$ob->lasteditedby=$_SESSION['userid'];
								$ob->lasteditedon=date("Y-m-d H:i:s");
								$ob->ipaddress=$_SERVER['REMOTE_ADDR'];
				
								$employeepaiddeductions->setObject($ob);
								if($ob->amount!=0){
								  $employeepaiddeductions->add($employeepaiddeductions);
								  
								  if($wr->type=="Office"){
								    $gnloans[$wr->id][$row->id]=$deduction;
								    $x++;
								    
								  }else{
								    $gnbankloans[$wr->id]+=$deduction;
								  }
								  
								  $ln = $rwf;//$employeeloans->fetchObject;
								  $emploans = new Employeeloans();
								  $ln->principal=round(($ln->principal-$ob->amount),2);
								  $emploans = $emploans->setObject($ln);
								  $emploans->edit($emploans);
								  
								  $ob="";
								  
								  $ob->amount=0;
								  $deduction=0;
								
								  if(strtolower($rwf->interesttype)=="amount"){
								    $deduction=$rwf->interest;
								  }
								  else{
								    if($rwf->method=="straight-line")
									  $deduction=$rwf->interest*$rwf->initialvalue/100;
								    elseif($rwf->method=="reducing balance")
									  $deduction=$rwf->interest*$principal/100;
								    }
								  
								  $totaldeductions+=$deduction;
								  //if($obj->deductions==1){
								  $employeepaiddeductions = new Employeepaiddeductions();

								  $ob=$obj;
								  $ob->deductionid=5;
								  $ob->loanid=$rwf->loanid;
								  $ob->employeeid=$row->id;
								  $ob->amount=$deduction;
								  $ob->reducing="Yes";
								  $ob->createdby=$_SESSION['userid'];
								  $ob->createdon=date("Y-m-d H:i:s");
								  $ob->lasteditedby=$_SESSION['userid'];
								  $ob->lasteditedon=date("Y-m-d H:i:s");
								  $ob->ipaddress=$_SERVER['REMOTE_ADDR'];
				  
								  $employeepaiddeductions->setObject($ob);
								  if($ob->amount!=0){
								    $employeepaiddeductions->add($employeepaiddeductions);
								    
								    if($wr->type=="Office"){
								      $gninterests[$wr->id][$row->id]=$deduction;
								      
								    }
								    else
								      $gnbankloans[$wr->id]+=$deduction;
								    
								    $ob="";
								  }
								  
								}
								
										
								}
							}
							
						}
				}
				elseif($rw->id==5){
				  continue;
				}
				elseif($rw->overall=="All" and $rw->id>5){
					//check if the to date is reached
					$fromdate=getDates($rw->fromyear, $rw->frommonth, 01);
					$todate=getDates($rw->toyear, $rw->tomonth, 01);
					if(!empty($rw->toyear) and !empty($rw->tomonth)){
					  if($now>=$fromdate and $now<=$todate){
							  //check frequency qualifier
							  $employeepaiddeductions=new Employeepaiddeductions();
							  $fields="hrm_employeepaiddeductions.id, hrm_employeepayments.id employeepaymentid, hrm_employeepaiddeductions.deductionid, hrm_employeepaiddeductions.employeeid, hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month, hrm_employeepaiddeductions.year, hrm_employeepaiddeductions.createdby, hrm_employeepaiddeductions.createdon, hrm_employeepaiddeductions.lasteditedby, hrm_employeepaiddeductions.lasteditedon";
							  $join=" left join hrm_employeepayments on hrm_employeepaiddeductions.employeepaymentid=hrm_employeepayments.id ";
							  $where=" where hrm_employeepaiddeductions.employeeid=$row->id and hrm_employeepaiddeductions.deductionid=$rw->id ";
							  $having="";
							  $groupby="";
							  $orderby=" order by hrm_employeepaiddeductions.id desc";
							  $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
							  $employeepaiddeductions->fetchObject;
							  
							  $next=getDates($employeepaiddeductions->year, $employeepaiddeductions->month+$rw->repeatafter, 01);
							  if($now>=$next){
								  $deduction=$rw->amount;
							  }
							  else{
								  $deduction=0;
							  }
					  }
					  else{
						  $deduction=0;
					  }
					}
					else{
					  $deduction=$rw->amount;
					}
					
					$employeepaiddeductions = new Employeepaiddeductions();

					$ob=$obj;
					$ob->deductionid=$rw->id;
					$ob->employeeid=$row->id;
					$ob->loanid='';
					$ob->amount=$deduction;
					if($rw->epays=="yes"){
					  $ob->employeramount=$deduction;
					}
					$ob->createdby=$_SESSION['userid'];
					$ob->createdon=date("Y-m-d H:i:s");
					$ob->lasteditedby=$_SESSION['userid'];
					$ob->lasteditedon=date("Y-m-d H:i:s");
					$ob->ipaddress=$_SERVER['REMOTE_ADDR'];

					$employeepaiddeductions->setObject($ob);
					if($deduction!=0)
					  $employeepaiddeductions->add($employeepaiddeductions);

					$gndeductions[$ob->deductionid]+=$deduction;
					
					$totaldeductions+=$deduction;
				}
				//check employee specific deductions
				else{
					$employeedeductions=new Employeedeductions();
					$fields="hrm_employeedeductions.id, hrm_deductions.deductiontype, hrm_deductions.name as deductionid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_deductiontypes.name as deductiontypeid, hrm_employeedeductions.amount, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
					$join=" left join hrm_deductions on hrm_employeedeductions.deductionid=hrm_deductions.id  left join hrm_employees on hrm_employeedeductions.employeeid=hrm_employees.id  left join hrm_deductiontypes on hrm_employeedeductions.deductiontypeid=hrm_deductiontypes.id ";
					$having="";
					$groupby="";
					$orderby="";
					//checks if deduction is still active
					$where=" where hrm_employeedeductions.employeeid=$row->id and hrm_employeedeductions.deductionid=$rw->id ";
					  if($rw->deductiontypeid==1){
					    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.frommonth)),concat('-',hrm_employeedeductions.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.tomonth)),concat('-',hrm_employeedeductions.toyear)),'%d-%m-%Y') ";
					  }
					$employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$employeedeductions = $employeedeductions->fetchObject;
					//if(!empty($employeedeductions->tomonth) and !empty($employeedeductions->toyear)){
					  $start=getDates($employeedeductions->fromyear, $employeedeductions->frommonth, 01);
					  $todate=getDates($employeedeductions->toyear, $employeedeductions->tomonth, 01);
					  
					  
					  $employeepaiddeductions=new Employeepaiddeductions();
					  $fields="hrm_employeepaiddeductions.id, hrm_employeepayments.id employeepaymentid, hrm_employeepaiddeductions.deductionid, hrm_employeepaiddeductions.employeeid, hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month, hrm_employeepaiddeductions.year, hrm_employeepaiddeductions.createdby, hrm_employeepaiddeductions.createdon, hrm_employeepaiddeductions.lasteditedby, hrm_employeepaiddeductions.lasteditedon";
					  $join=" left join hrm_employeepayments on hrm_employeepaiddeductions.employeepaymentid=hrm_employeepayments.id ";
					  $where=" where hrm_employeepaiddeductions.employeeid=$row->id and hrm_employeepaiddeductions.deductionid=$rw->id ";
					  $having="";
					  $groupby="";
					  $orderby=" order by hrm_employeepaiddeductions.id desc";
					  $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					  $employeepaiddeductions->fetchObject;
					  
					  $next=getDates($employeepaiddeductions->year, $employeepaiddeductions->month+$rw->repeatafter, 01);
					  
// 					  if($now>=$start and $now<=$todate and $next>=$now){
						  if($employeedeductions->deductiontype=="%"){
						    $deduction=$rw->amount*$basic/100;if($row->id==3)echo $employeedeductions->deductionid." == ".$employeedeductions->deductiontype." == ".$deduction."=".$rw->amount."*".$basic;
						  }
						  else
						    $deduction=$employeedeductions->amount;
// 					  }
// 					  else{echo "Here";
// 						  $deduction=0;
// 					  }
// 					}
// 					else{
// 					  $deduction=$employeedeductions->amount;
// 					}
					
					$employeepaiddeductions = new Employeepaiddeductions();

					$ob=$obj;
					$ob->deductionid=$rw->id;
					$ob->employeeid=$row->id;
					$ob->loanid='';
					$ob->amount=$deduction;
					if($rw->epays=="yes"){
					  $ob->employeramount=$deduction;
					}
					$ob->createdby=$_SESSION['userid'];
					$ob->createdon=date("Y-m-d H:i:s");
					$ob->lasteditedby=$_SESSION['userid'];
					$ob->lasteditedon=date("Y-m-d H:i:s");
					$ob->ipaddress=$_SERVER['REMOTE_ADDR'];

					$employeepaiddeductions->setObject($ob);
					if($deduction!=0)
					  $employeepaiddeductions->add($employeepaiddeductions);

					$gndeductions[$ob->deductionid]+=$deduction;
					
					$totaldeductions+=$deduction;
				}
				
				
			}
						
						$surchages = new Surchages();
						$fields="*";
						$join="";
						$having="";
						$groupby="";
						$orderby="";
						$where=" where status='Active'";
						$surchages->retrieve($fields, $join, $where, $having, $groupby, $orderby);
						while($wr=mysql_fetch_object($surchages->result)){
							$employeesurchages = new Employeesurchages();
							$fields="*";
							$join="";
							$having="";
							$groupby="";
							$orderby="";
							$where=" where employeeid='$row->id' and surchageid='$wr->id' ";
							
// 					  if($rw->deductiontypeid==1){
					    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',frommonth)),concat('-',fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',tomonth)),concat('-',toyear)),'%d-%m-%Y') ";
// 					  }
							$employeesurchages->retrieve($fields, $join, $where, $having, $groupby, $orderby);
							if($employeesurchages->affectedRows>0){
								while($rw=mysql_fetch_object($employeesurchages->result)){
									$surchage=$rw->amount;
									$totaldeductions+=$surchage;
									//if($obj->deductions==1){
									$employeepaidsurchages = new Employeepaidsurchages();

									$ob=$obj;
									$ob->empsurchageid=$wr->id;
									$ob->employeeid=$row->id;
									$ob->amount=$surchage;
									$ob->month=$obj->month;
									$ob->year=$obj->year;
									$ob->createdby=$_SESSION['userid'];
									$ob->createdon=date("Y-m-d H:i:s");
									$ob->lasteditedby=$_SESSION['userid'];
									$ob->lasteditedon=date("Y-m-d H:i:s");
									$ob->ipaddress=$_SERVER['REMOTE_ADDR'];
					
									$employeepaidsurchages->setObject($ob);
									$employeepaidsurchages->add($employeepaidsurchages);
									
									$gnincomes[$ob->empsurchageid]+=$surchage;
									
									//}
								}
							}
							
						}

			$netpay=$grosspay+$nontaxablearrears-$totaldeductions;
				
			$employeepayments = new Employeepayments();
				
			$ob=$obj;
			$ob->employeeid=$row->id;
			$ob->assignmentid=$row->assignmentid;
			$ob->employeebankid=$row->employeebankid;
			$ob->bankbrancheid=$row->bankbrancheid;
			$ob->bankacc=$row->bankacc;
			$ob->clearingcode=$row->clearingcode;
			$ob->ref=$row->ref;
			$ob->basic=$row->basic;
			$ob->allowances=$totalallowances;
			$ob->deductions=$totaldeductions;
			$ob->netpay=$netpay;
			$ob->createdby=$_SESSION['userid'];
			$ob->createdon=date("Y-m-d H:i:s");
			$ob->lasteditedby=$_SESSION['userid'];
			$ob->lasteditedon=date("Y-m-d H:i:s");
			$ob->ipaddress=$_SERVER['REMOTE_ADDR'];
				
			$employeepayments->setObject($ob);
			$employeepayments->add($employeepayments);
			
			$gnsalaries[0]+=$basic;
		}
	}
	
	$gn['allowances'] = $gnallowances;
	$gn['arrears'] = $gnarrears;
	$gn['deductions'] = $gndeductions;
	$gn['loans'] = $gnbankloans;
	$gn['officeloans'] = $gnloans;
	$gn['interests'] = $gninterests;
	$gn['salaries'] = $gnsalaries;
	$gn['surchages'] = $gnincomes;
	
// 	print_r($gn);
	
	//push to chart of accounts
	$employeepayments = new Employeepayments();
	$employeepayments->generalJournal($gn,$obj);
}
include 'employeepayments.php';
?>