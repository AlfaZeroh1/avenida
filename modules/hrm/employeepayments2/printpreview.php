<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../employees/Employees_class.php';
require_once("../employeepaidallowances/Employeepaidallowances_class.php");
require_once("../employeeallowances/Employeeallowances_class.php");
require_once("../allowances/Allowances_class.php");
require_once("../employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../employeepaidarrears/Employeepaidarrears_class.php");
require_once '../employeepaidsurchages/Employeepaidsurchages_class.php';
require_once("../employeepayments/Employeepayments_class.php");
require_once '../assignments/Assignments_class.php';
require_once("../../hrm/departments/Departments_class.php");
require_once "../loans/Loans_class.php";
require_once "../employeeloans/Employeeloans_class.php";
require_once("../../hrm/overtimes/Overtimes_class.php");
require_once("../../hrm/employeeovertimes/Employeeovertimes_class.php");
require_once("../../hrm/employeeclockings/Employeeclockings_class.php");
require_once("../../hrm/arrears/Arrears_class.php");
require_once("../../hrm/employeearrears/Employeearrears_class.php");
require_once("../../hrm/deductions/Deductions_class.php");
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

$month=$_GET['month'];
$year=$_GET['year'];

$printedon=formatDate(Date("Y-m-d"))." ".Date("H :i :s");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PAYSLIP</title>

<script type="text/javascript">
  function print_doc()
  {
		
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{alert(i+": "+printers[i]);
			if(printers[i].indexOf('<?php echo SPRINTER; ?>')>-1)
			{	
				jsPrintSetup.setPrinter(printers[i]);
			}
			
		}
		//set number of copies to 2
		jsPrintSetup.setOption('numCopies','1');
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginLeft','1');
		jsPrintSetup.setOption('marginRight','1');
		jsPrintSetup.setOption('marginTop','1');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
<style media="print" type="text/css">
.noprint{ display:none;}
body {font-family:'Tahoma';font-size:10px;}
</style>

</head>

<body onload="print_doc();">
<?php
$x=0;
$shps = $_SESSION['shps'];//print_r($shps);
$num = count($shps);
// while($x<$num){
foreach($shps as $id){
// $id=$shps[$x];
?>
<div align="left" id="print_content" style="width:98%; margin:0px auto;">

   <table class="tgrid gridd" width="40%" cellspacing="0" align="left" style="margin-right:20px;">
   <thead> 
   <tr>
   <td colspan="9" align="center"> <img src="../../../images/magana-logo.png" width="240" height="120"/></td>
   </tr>
   <tr><td colspan="9"><div>
   <div class="hfields" align="left">
 <div align="center" style="font-weight:bold;page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:none;">

 <span style="display:block; padding:0px 0px 2px;"><?php echo COMPANY_NAME;?> </span>
<span style="display:block; padding:0px 0px 1px;"><?php echo COMPANY_TYPE;?> </span>
<span style="display:block; padding:0px 0px 1px;"><?php echo COMPANY_ADDR;?> </span>
<span style="display:block; padding:0px 0px 1px;"><?php echo COMPANY_TOWN;?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo COMPANY_DESC;?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo COMPANY_TEL;?> </span>
<span style="display:block; padding:0px;"><?php echo COMPANY_DESC;?></span> </div>
<?php if(PRINTTITLE==1){
 ?>
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999"><?php echo COMPANY_NAME; ?></span></div>
 <?php 
 }?>
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999">Pay Slip</span></div>
 <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;font-size: 14;">
 
 Payment for: <?php echo date("M",mktime(0, 0, 0, $month, 1)).' '.$year; ?><br/>
 Printed on: <span style="font-size:10px;"><?php echo date("Y-m-d H:i:s");?></span></div>
 
   </div></td></tr>
   <tr>
<th colspan="3"><hr /></th>
</tr>
  <tr style="font-size:12px;">
  <?php 
  
        $employees = new Employees();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$id'";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employees->sql;
	$emp=$employees->fetchObject;//echo "HERERERE";
	
	$employeepayments = new Employeepayments();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where employeeid='$emp->id'";
	$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$pay=$employeepayments->fetchObject;
	
	//$check=retrieveScheduleByEmployee($emp->id);
	
	$assignments = new Assignments();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$emp->assignmentid'";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$ass=$assignments->fetchObject;
	
	$departments = new Departments();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$ass->departmentid'";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$dept=$departments->fetchObject; 
  
  ?> 
  
<th colspan="3">Name:&nbsp;<strong>

<?php echo initialCap($emp->firstname); ?>&nbsp;<?php echo initialCap($emp->middlename); ?>&nbsp;<?php echo initialCap($emp->lastname); ?></strong></th>
</tr>
<tr valign="top" style="font-size:12px; ">
	  <td width="60%">Id No:</td>
      <td colspan="2"><?php echo $emp->idno; ?></td>
	  </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td width="60%">Payroll No:</td>
      <td colspan="2"><?php echo $emp->pfnum; ?></td>
	  </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td width="60%">Pin No:</td>
      <td colspan="2"><?php echo $emp->pinno; ?></td>
	  </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >Assignment:</td>
      <td colspan="2"><?php echo $ass->name; ?></td>
	  </tr>
	  <tr valign="top" style="font-size:12px; ">
	  <td >Department:</td>
      <td colspan="2"><?php echo $dept->name; ?></td>
	  </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >Grade:</td>
      <td colspan="2"><?php echo $emp->grade; ?></td>
	  </tr>
<tr>
<th colspan="3"><hr /></th>
</tr>
</thead>
		<tbody class="" style="width:80%;  " align="left">    
	  <tr>
	  <td colspan="3" align="left"><u>PAYMENTS</u></td>
	  </tr>	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >Basic Salary:</td>
	  <?php  
	  $taxable=0;
	  $totalallowances=0;
	  $totalarrears=0;
	  $totalarrears1=0;
	  $grosspay=0;
	  $employeeclockings = new Employeeclockings();
		if($emp->type==2){
			
		  
		  $fields="count(distinct today) days";
		  $join=" ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where employeeid='$row->id' and today between '$obj->fromdate' and '$obj->todate' ";
		  $employeeclockings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  
		  //if($employeeclockings->affectedRows>=0){
		    $employeeclockings = $employeeclockings->fetchObject;
		    //continue;
		  //}
		  $emp->basic=$row->basic*12*$employeeclockings->days/(365);
		}
		else{
			  $emp->basic=$emp->basic;
		}
		$taxable+=$emp->basic;
	    ?>
          <td align="right"><?php echo formatNumber($emp->basic); ?></td>
	  <td>&nbsp;</td>
	  </tr>
	 <?php
			$totalarrears=0;
			$arrears = new Arrears();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id in(select arrearid from hrm_employeearrears where month='$obj->month' and year='$obj->year') and hrm_arrears.taxable='Yes'";
			$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			//$res=$arrears->result;
			$x=0;
			while($r=mysql_fetch_object($arrears->result)){
			
			   $employeearrears = new Employeearrears();
			    $fields="*";
			    $join=" ";
			    $where=" where hrm_employeearrears.arrearid='$r->id' and hrm_employeearrears.employeeid='$emp->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $employeearrears = $employeearrears->fetchObject;
			    
			    $totalarrears+=$employeearrears->amount;
			    if($employeearrears->amount>0){
			  ?>
			  <tr valign="top" style="font-size:12px; ">
			  <td ><?php echo initialCap($r->name); ?>:</td>
			  <td align="right"><?php echo formatNumber($employeearrears->amount); ?></td>
			  <td>&nbsp;</td>
			  </tr>
			  <?php
			  }
			  $x++;
			}
			?>
			<?php if($x>0){?>
			<?php }?>
	  <tr valign="top" style="font-size:12px; ">
	<?php        $allowances=new Allowances();
			$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowancetypes.repeatafter, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.noncashbenefit, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
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
							  $where=" where hrm_employeepaidallowances.employeeid=$emp->id and hrm_employeepaidallowances.allowanceid=$rw->id ";
							  $having="";
							  $groupby="";
							  $orderby=" order by hrm_employeepaidallowances.id desc";
							  $employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
							  $employeepaidallowances->fetchObject;
							  $next=getDates($employeepaidallowances->year, $employeepaidallowances->month+$row->repeatafter, 01);
							  if($next<=$now){
								  $allowance=$row->amount;
								  $taxable+=($row->amount*$rw->percentaxable);
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
					  $taxable+=($row->amount*$rw->percentaxable);
					}
					if($allowance>0){
					  ?>
						  <tr valign="top" style="font-size:12px; ">
						  <td ><?php echo initialCap($rw->name); ?>:</td>
						  <td align="right"><?php echo formatNumber($allowance); ?></td>
						  <td>&nbsp;</td>
						  </tr>
					  <?php 
					  }
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
					    $where=" where overtimeid='$ov->id' and employeeid='$emp->id' and month='$obj->month' and year='$obj->year' ";
					    $having="";
					    $groupby="";
					    $orderby="";
					    $employeeovertimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeeovertimes->sql;
					    $employeeovertimes = $employeeovertimes->fetchObject;
					    
					    $employeeovertimes->amount=($emp->id/ ($ov->hrs*52/12) *$ov->value)*$employeeovertimes->hrs;
					    $taxable+=($employeeovertimes->amount*$rw->percentaxable);
					    $allowance=$employeeovertimes->amount;
					    if($employeeovertimes->amount>0){
					    ?>
					            <tr valign="top" style="font-size:12px; ">
						    <td ><?php echo $rw->name."(".$employeeovertimes->hrs.")"; ?>:</td>
						    <td align="right"><?php echo formatNumber($employeeovertimes->amount); ?></td>
						    <td>&nbsp;</td>
						    </tr>
					    <?php 
					    }
					    $totalallowances+=$allowance;
					    if($rw->noncashbenefit=="Yes"){
					    $totalnoncashbenefit+=$allowance;
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
					  $where=" where hrm_employeeallowances.employeeid=$emp->id and hrm_employeeallowances.allowanceid=$rw->id ";
					   if($rw->allowancetypeid==2){
					    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeeallowances.frommonth)),concat('-',hrm_employeeallowances.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeeallowances.tomonth)),concat('-',hrm_employeeallowances.toyear)),'%d-%m-%Y') ";
					  }
					  $employeeallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($row->id==99 and $rw->id==10)echo $employeeallowances->sql.";<br/>";
					  $employeeallowances = $employeeallowances->fetchObject;
					  
					  if(!empty($employeeallowances->tomonth) and !empty($employeeallowances->toyear)){
					    $start=getDates($employeeallowances->fromyear, $employeeallowances->frommonth, 01);
					    $todate=getDates($employeeallowances->toyear, $employeeallowances->tomonth, 01);
					    $next=getDates($employeeallowances->year, $employeeallowances->month+$rw->repeatafter, 01);
					    if($now>=$start and $now<=$todate and $next>=$now){
						    $allowance=$employeeallowances->amount;
						    $taxable+=($employeeallowances->amount*$rw->percentaxable);
					    }
					    else{
						    $allowance=0;
					    }
					  }
					  else{
					    $allowance=$employeeallowances->amount;
					    $taxable+=($employeeallowances->amount*$rw->percentaxable);
					  }
					  if($allowance>0){
					  ?>
						  <tr valign="top" style="font-size:12px; ">
						  <td ><?php echo $rw->name; ?>:</td>
						  <td align="right"><?php echo formatNumber($allowance); ?></td>
						  <td>&nbsp;</td>
						  </tr>
					  <?php 
					  }
					  $totalallowances+=$allowance;
					  if($rw->noncashbenefit=="Yes"){
					  $totalnoncashbenefit+=$allowance;
					  }
				      }
				} ?>
				
				
	<?php		  
			}
	  
	  ?>
      </tr>
	  </tr>
	  <tr valign="top" style="font-size:12px; ">
	  <td>&nbsp;</td>
      <td align="right"><hr/></td>
	  </tr>
	  <tr valign="top" style="font-size:12px; ">
	  <td ></td>
	  <td>&nbsp;</td>
      <td align="right"><?php $grosspay=$emp->basic+$totalallowances+$totalarrears; echo formatNumber($emp->basic+$totalallowances+$totalarrears) ?></td>
	  </tr>
	  
	   <tr valign="top" style="font-size:12px; ">
	  <td colspan="3" align="left"><u>DEDUCTIONS</u></td>
	  </tr>	
	  <?php 
			$totaldeductions = 0;
			$employeedeductionexempt=new Employeedeductionexempt();
			$deductions=new Deductions();
			$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.amount, hrm_deductions.deductiontypeid, hrm_deductiontypes.repeatafter, hrm_deductions.overall, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
			$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			//to ensure that the deduction is active
			$where=" where  hrm_deductions.status='active'";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $deductions->sql;
			while($rw=mysql_fetch_object($deductions->result)){
			$deduction=0;
			$now=getDates($obj->year, $obj->month, 01);
				//check deductions that affect all
				if($rw->id==1){
					//get PAYE
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$emp->id,$obj->month,$obj->year))
					{
					$payes = new Payes();
					//get NSSF
					$nssfs = new Nssfs();
					$taxable=$payes->getTaxable($taxable, $emp->id, $obj);//$taxable-$nssfs->getNSSF($grosspay);
					$deduction=$payes->getPAYE($taxable,$emp->id,$obj);
					}
					//if($row->id==276)echo $taxable." == ".$deduction."<br/>";
				}
				elseif ($rw->id==2){
					//get NHIF
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$emp->id,$obj->month,$obj->year))
					{
					$nhifs = new Nhifs();
					$deduction=$nhifs->getNHIF($grosspay);//if($row->id==276)echo $taxable." == ".$deduction."<br/>";
					}
				}
				elseif ($rw->id==3){				         
					//get NSSF
					if(!$employeedeductionexempt->checkEmployeeDEductionStatus($rw->id,$emp->id,$obj->month,$obj->year))
					{
					$nssfs = new Nssfs();
					$deduction=$nssfs->getNSSF($grosspay);//if($row->id==276)echo $taxable." == ".$deduction."<br/>";
					}
				}
				elseif($rw->overall=="All" and ($rw->id!=1 and $rw->id!=2 and $rw->id!=3)){ 
					//check if the to date is reached
					$fromdate=getDates($rw->fromyear, $rw->frommonth, 01);
					$todate=getDates($rw->toyear, $rw->tomonth, 01);
					if(!empty($rw->toyear) and !empty($rw->tomonth)){
					  if($now>=$fromdate and $now<=$todate){
							  //check frequency qualifier
							  $employeepaiddeductions=new Employeepaiddeductions();
							  $fields="hrm_employeepaiddeductions.id, hrm_employeepayments.id employeepaymentid, hrm_employeepaiddeductions.deductionid, hrm_employeepaiddeductions.employeeid, hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month, hrm_employeepaiddeductions.year, hrm_employeepaiddeductions.createdby, hrm_employeepaiddeductions.createdon, hrm_employeepaiddeductions.lasteditedby, hrm_employeepaiddeductions.lasteditedon";
							  $join=" left join hrm_employeepayments on hrm_employeepaiddeductions.employeepaymentid=hrm_employeepayments.id ";
							  $where=" where hrm_employeepaiddeductions.employeeid=$emp->id and hrm_employeepaiddeductions.deductionid=$rw->id ";
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
				}
				//check employee specific deductions
				else{
					 $employeedeductions=new Employeedeductions();
					  $fields="hrm_employeedeductions.id, hrm_deductions.name as deductionid, hrm_deductions.deductiontype, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_deductiontypes.name as deductiontypeid, sum(hrm_employeedeductions.amount) amount, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
					  $join=" left join hrm_deductions on hrm_employeedeductions.deductionid=hrm_deductions.id  left join hrm_employees on hrm_employeedeductions.employeeid=hrm_employees.id  left join hrm_deductiontypes on hrm_employeedeductions.deductiontypeid=hrm_deductiontypes.id ";
					  $having="";
					  $groupby=" group by deductionid ";
					  $orderby="";
					  //checks if deduction is still active
					  $where=" where hrm_employeedeductions.employeeid=$emp->id and hrm_employeedeductions.deductionid=$rw->id ";
					  if($rw->deductiontypeid==1){
					    $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.frommonth)),concat('-',hrm_employeedeductions.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.tomonth)),concat('-',hrm_employeedeductions.toyear)),'%d-%m-%Y') ";
					  }
					  $employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($row->id==5 and $rw->id==29){echo $employeedeductions->sql."<br/>";}
					  $employeedeductions = $employeedeductions->fetchObject;
					  
					$fromdate=getDates($employeedeductions->fromyear, $employeedeductions->frommonth, 01);
					$todate=getDates($employeedeductions->toyear, $employeedeductions->tomonth, 01);	//if($row->id==18 and $rw->id==7){echo $fromdate." = ".$now." = ".$todate."<br/>";}
					if($now>=$fromdate and $now<=$todate){
					  $next=getDates($employeedeductions->fromyear, ($employeedeductions->frommonth+$row->repeatafter), 01,$row->id);
					  if($next<=$now){//if($row->id==1)echo $employeedeductions->deductionid." == ".$employeedeductions->deductiontype;
						  if($employeedeductions->deductiontype=="%")
						    $deduction=$employeedeductions->amount*$basic;
						  else
						    $deduction=$employeedeductions->amount;
					  }
					  else{
						  $deduction=0;
					  }
					}else{
					  $deduction=0;
					}
				}
								
				if($rw->id==4){
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
					  $orderby=" order by id desc limit 1 ";
					  $where=" where employeeid='$emp->id' and loanid='$wr->id' and principal>0 ";
					  $employeeloans->retrieve($fields, $join, $where, $having, $groupby, $orderby); 
					  if($employeeloans->affectedRows>0){
						  while($rww=mysql_fetch_object($employeeloans->result)){		
							  if($rww->principal>$rww->payable)
							    $deduction=$rww->payable;
							  else	
							    $deduction=$rww->principal;
							    
							  $totaldeductions+=$deduction;
							  if($deduction>0){
								  ?>
								  <tr valign="top" style="font-size:12px; ">
								  <td ><?php echo $wr->name; ?>:</td>
								  <td align="right"><?php echo formatNumber($deduction); ?></td>
								  <td>&nbsp;</td>
								  </tr>
								  <?php 
								  }
								  if(strtolower($rww->interesttype)=="amount"){
								    $deduction=$rww->interest;
								  }
								  else{
								    if($rww->method=="straight-line")
									    $deduction=$rww->interest*$rww->initialvalue*$rww->duration/100;
								    elseif($rww->method=="reducing balance")
									    $deduction=$rww->interest*$rww->principal/100;	
									    
								    }
								  
								  $totaldeductions+=$deduction;
								  if($deduction>0){
								  ?>
								  <tr valign="top" style="font-size:12px; ">
								  <td ><?php echo $wr->name." Interest"; ?>:</td>
								  <td align="right"><?php echo formatNumber($deduction); ?></td>
								  <td>&nbsp;</td>
								  </tr>
								  <?php 
								  }
						  }
					  }
				  }
				 }
				 elseif($rw->id==5){
				  continue;
				 }
				 else{
				
				        $employeedeductions=new Employeedeductions();
					$fields="hrm_employeedeductions.id, hrm_deductions.deductiontype, hrm_deductions.name as deductionid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_deductiontypes.name as deductiontypeid, hrm_employeedeductions.amount, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
					$join=" left join hrm_deductions on hrm_employeedeductions.deductionid=hrm_deductions.id  left join hrm_employees on hrm_employeedeductions.employeeid=hrm_employees.id  left join hrm_deductiontypes on hrm_employeedeductions.deductiontypeid=hrm_deductiontypes.id ";
					$having="";
					$groupby="";
					$orderby="";
					//checks if deduction is still active
					$where=" where hrm_employeedeductions.employeeid=$emp->id and hrm_employeedeductions.deductionid=$rw->id ";
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
					 if($rw->id!=1 and $rw->id!=2 and $rw->id!=3)
					 {
					  if($now>=$start and $now<=$todate and $next>=$now){
						  if($employeedeductions->deductiontype=="%"){
						    $deduction=$rw->amount*$basic/100;
						  }
						  else
						    $deduction=$employeedeductions->amount;
					//if($row->id==33)echo $employeedeductions->deductionid." == ".$employeedeductions->deductiontype." == ".$deduction."=".$rw->amount."*".$basic;	 
					}
					}
				  $totaldeductions+=$deduction;
				  if($deduction>0){
				  ?>
					 <tr valign="top" style="font-size:12px; ">
					    <td ><?php echo $rw->name; ?>:</td>
					    <td align="right"><?php echo formatNumber($deduction); ?></td>
					    <td>&nbsp;</td>
					</tr>
			      <?php 
			      }
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
				$fields="sum(amount) amount";
				$join="";
				$having="";
				$groupby=" ";
				$orderby="";
				$where=" where employeeid='$emp->id' and surchageid='$wr->id' ";
				$date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
					    
					    $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',frommonth)),concat('-',fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',tomonth)),concat('-',toyear)),'%d-%m-%Y') ";
				$employeesurchages->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				if($employeesurchages->affectedRows>0){
					while($rw=mysql_fetch_object($employeesurchages->result)){
						$deduction=$rw->amount;
						$totaldeductions+=$deduction;
						if($deduction>0){
						?>
						<tr valign="top" style="font-size:12px; ">
						<td >sss<?php echo $wr->name; ?>:</td>
						<td align="right"><?php echo formatNumber($deduction); ?></td>
						<td>&nbsp;</td>
						</tr>
						<?php 
						}
					}
				}
			}
	  ?>
      
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >&nbsp;</td>
      <td align="right"><hr/></td>
      <td>&nbsp;</td>
	  </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >Total Deductions:</td>
	  <td>&nbsp;</td>
          <td align="right"><?php echo formatNumber($totaldeductions); ?></td>
	  </tr>
	  <?php
	    $totalarrears1=0;
	    $arrears = new Arrears();
	    $fields="*";
	    $join="";
	    $having="";
	    $groupby="";
	    $orderby="";
	    $where=" where id in(select arrearid from hrm_employeearrears where month='$obj->month' and year='$obj->year') and hrm_arrears.taxable='No'";
	    $arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    //$res=$arrears->result;
	    $x=0;
	    while($r=mysql_fetch_object($arrears->result)){
	    
		$employeearrears = new Employeearrears();
		$fields="*";
		$join=" ";
		$where=" where hrm_employeearrears.arrearid='$r->id' and hrm_employeearrears.employeeid='$emp->id' and hrm_employeearrears.month='$obj->month' and hrm_employeearrears.year='$obj->year'";
		$having="";
		$groupby="";
		$orderby="";
		$employeearrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeearrears = $employeearrears->fetchObject;
		
		$totalarrears1+=$employeearrears->amount;
		if($employeearrears->amount>0){
	      ?>
	      <tr valign="top" style="font-size:12px; ">
	      <td ><?php echo $r->name; ?>:</td>
	      <td align="right"><?php echo formatNumber($employeearrears->amount); ?></td>
	      <td>&nbsp;</td>
	      </tr>
	      <?php
	      }
	      $x++;
	    }
	    ?>	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><hr/></td>
	  </tr>
	  <?php $netpay=($grosspay-$totalnoncashbenefit)-$totaldeductions+$totalarrears1; ?>
	  <tr valign="top" style="font-size:12px; ">
	  <td >Net Pay:</td>
	  <td>&nbsp;</td>
      <td align="right"><?php echo formatNumber($netpay); ?></td>
	  </tr>
	  
	  <tr valign="top" style="font-size:1principal2px; ">
	  <td >&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><hr/></td>
	  </tr>
	  
	   <tr valign="top" style="font-size:12px; ">
	  <td colspan="3" align="left"><u>STATEMENT</u></td>
	  </tr>	
	  
	<?php
	$date=date("Y-m-d",mktime(0,0,0,($month+1),1,$year));
	$deductions = new Deductions();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where statement='yes'";
	$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($row=mysql_fetch_object($deductions->result)){
	
	if($row->id==4){
	  $employeeloans = new Employeeloans();
	  $fields=" hrm_employeeloans.id,hrm_loans.name, hrm_employeeloans.principal,hrm_employeeloans.payable,hrm_employeeloans.loanid ";
	  $join=" left join hrm_loans on hrm_loans.id=hrm_employeeloans.loanid ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where employeeid='$emp->id' and loanid in (select loanid from hrm_employeepaiddeductions where employeeid='$emp->id' and year not in(2014))";
	  $employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	   
	  while($rw=mysql_fetch_object($employeeloans->result)){
		$employeepaiddeduction = new Employeepaiddeductions();
		$fields="sum(hrm_employeepaiddeductions.amount) amount";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeepaiddeductions.employeeid='$emp->id' and deductionid='4' and loanid='$rw->loanid' and concat(year,'-',concat(LPAD(month,2,'0'),'-','01'))>='$date'";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaiddeduction->sql."HERERE";
		$employeepaiddeduction=$employeepaiddeduction->fetchObject;
		
		$emploans = new Employeeloans();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby=" order by id desc limit 1 ";
		$where=" where employeeid='$emp->id' and loanid='$rw->loanid' and id='$rw->id' and principal>0 ";
		$emploans->retrieve($fields, $join, $where, $having, $groupby, $orderby); //echo $emploans->sql;
		$emploans=$emploans->fetchObject;
		
		if($emploans->principal>$emploans->payable)
		  $loanded=$emploans->payable;
		else	
		  $loanded=$emploans->principal;
		  $tt=0;
		  $tt=$rw->principal+$employeepaiddeduction->amount+$loanded;
		if($tt>0){
	    ?>
	    <tr valign="top" style="font-size:12px; ">
	      <td ><?php echo substr($rw->name,0,30); ?>:</td>
	      <td>&nbsp;</td>
	      <td align="right"><?php echo formatNumber($rw->principal-$loanded); ?></td>
	      </tr>
	    <?php
	    }
	  }
	}
	else if($row->id==5){
	  continue;
	}
	else{
	  $employeepaiddeductions = new Employeepaiddeductions();
	  $fields=" sum(amount) amount, sum(employeramount) employeramount";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where employeeid='$emp->id' and deductionid='$row->id' and concat(year,'-',concat(LPAD(month,2,'0'),'-','01'))<'$date' and year not in(2014)";
	  $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaiddeductions->sql;
	  $employeepaiddeductions = $employeepaiddeductions->fetchObject;

	  $employeededuct=new Employeedeductions();
	  $fields="hrm_employeedeductions.id, hrm_deductions.deductiontype, hrm_deductions.name as deductionid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_deductiontypes.name as deductiontypeid, hrm_employeedeductions.amount, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
	  $join=" left join hrm_deductions on hrm_employeedeductions.deductionid=hrm_deductions.id  left join hrm_employees on hrm_employeedeductions.employeeid=hrm_employees.id  left join hrm_deductiontypes on hrm_employeedeductions.deductiontypeid=hrm_deductiontypes.id ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  //checks if deduction is still active
	  $where=" where hrm_employeedeductions.employeeid=$emp->id and hrm_employeedeductions.deductionid=$row->id ";
	    if($rw->deductiontypeid==1){
	      $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
	      
	      $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.frommonth)),concat('-',hrm_employeedeductions.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.tomonth)),concat('-',hrm_employeedeductions.toyear)),'%d-%m-%Y') ";
	    }
	  $employeededuct->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeededuct->sql;
	  $employeededuct = $employeededuct->fetchObject;
	  //if(!empty($employeedeductions->tomonth) and !empty($employeedeductions->toyear)){
	    $start=getDates($employeededuct->fromyear, $employeededuct->frommonth, 01);
	    $todate=getDates($employeededuct->toyear, $employeededuct->tomonth, 01);
	    
	    $deduction=0;
	    $employeepaiddeduct=new Employeepaiddeductions();
	    $fields="hrm_employeepaiddeductions.id, hrm_employeepayments.id employeepaymentid, hrm_employeepaiddeductions.deductionid, hrm_employeepaiddeductions.employeeid, hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month, hrm_employeepaiddeductions.year, hrm_employeepaiddeductions.createdby, hrm_employeepaiddeductions.createdon, hrm_employeepaiddeductions.lasteditedby, hrm_employeepaiddeductions.lasteditedon";
	    $join=" left join hrm_employeepayments on hrm_employeepaiddeductions.employeepaymentid=hrm_employeepayments.id ";
	    $where=" where hrm_employeepaiddeductions.employeeid=$emp->id and hrm_employeepaiddeductions.deductionid=$row->id ";
	    $having="";
	    $groupby="";
	    $orderby=" order by hrm_employeepaiddeductions.id desc";
	    $employeepaiddeduct->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    $employeepaiddeduct->fetchObject;
	    
	    $next=getDates($employeepaiddeduct->year, $employeepaiddeduct->month+$rw->repeatafter, 01);
	    if($row->id!=1 and $row->id!=2 and $row->id!=3)
	    {
	    if($now>=$start and $now<=$todate and $next>=$now){
		    if($employeededuct->deductiontype=="%"){
		      $deduction=$row->amount*$basic/100;
		    }
		    else
		      $deduction=$employeededuct->amount;
	  //echo $employeepaiddeduct->deductionid." == ".$employeepaiddeduct->deductiontype." == ".$deduction."=".$rw->amount."*".$basic;	 
	  }
	  }
	  	  
	  $employeepaiddeduction->amount=$employeepaiddeductions->amount+$deduction;
	  $employeepaiddeduction->employeramount=$employeepaiddeductions->employeramount+$deduction;
// 	  if($row->epays=="yes"){
// 	    $employeepaiddeductions->amount+=$employeepaiddeductions->employeramount;
// 	  }
	}
	if($employeepaiddeductions->amount>0){
	if($row->epays=="yes"){
	?>	
	  <tr valign="top" style="font-size:12px; ">	
	  <td ><?php echo substr($row->name,0,30); ?> (Employee Contribution):</td>
	  <td><?php echo formatNumber($employeepaiddeduction->amount); ?></td>
	  <td align="right">&nbsp;</td>
	  </tr>
	  <tr valign="top" style="font-size:12px; ">	
	  <td ><?php echo substr($row->name,0,30); ?> (Employer Contribution):</td>
	  <td><?php echo formatNumber($employeepaiddeduction->employeramount); ?></td>
	  <td align="right">&nbsp;</td>
	  </tr>
	  <tr valign="top" style="font-size:12px; ">	
	  <td ><?php echo substr($row->name,0,30); ?> (Total Contribution):</td>
	  <td>&nbsp;</td>
	  <td align="right"><?php echo formatNumber($employeepaiddeduction->amount+$employeepaiddeduction->employeramount); ?></td>
	  </tr>	  
	<?php }else{ ?>
	<tr valign="top" style="font-size:12px; ">	
	  <td ><?php echo substr($row->name,0,30); ?>:</td>
	  <td>&nbsp;</td>
	  <td align="right"><?php echo formatNumber($employeepaiddeduction->amount); ?></td>
	  </tr>
	<?php
	}
	}
	}
	?>
	<tr valign="top" style="font-size:12px; ">
	  <td colspan='3' align="center"><?php echo COMPANY_SLOGAN; ?></td>
	  </tr>
         <tr valign="top" style="font-size:12px; line-height:700px; ">
	  <td colspan='3' align="center">&nbsp;</td>
	  </tr>
      </tbody>
  </table> 
 
  
</div>
<?php
  $x++;
  }
  ?>
</body>
</html>
