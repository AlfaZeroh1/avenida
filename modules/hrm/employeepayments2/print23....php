<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../employees/Employees_class.php';
require_once("../employeepaidallowances/Employeepaidallowances_class.php");
require_once("../employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../employeepaidarrears/Employeepaidarrears_class.php");
require_once '../employeepaidsurchages/Employeepaidsurchages_class.php';
require_once("../employeepayments/Employeepayments_class.php");
require_once '../assignments/Assignments_class.php';
require_once("../../hrm/departments/Departments_class.php");
require_once "../loans/Loans_class.php";
require_once "../employeeloans/Employeeloans_class.php";
require_once("../../hrm/overtimes/Overtimes_class.php");
require_once("../../hrm/deductions/Deductions_class.php");



$id=$_GET['id'];
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
		jsPrintSetup.setOption('numCopies',<?php echo RECEIPTCOPIES; ?>);
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginLeft','1');
		jsPrintSetup.setOption('marginRight','1');
		
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
<div align="left" id="print_content" style="width:98%; margin:0px auto;">
   <table class="tgrid gridd" width="50%" cellspacing="0" align="left">
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
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$emp=$employees->fetchObject;
	
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
      <td align="right"><?php echo formatNumber($emp->basic); ?></td>
	  <td>&nbsp;</td>
	  </tr>
	  <tr valign="top" style="font-size:12px; ">
	  <?php 
	$employeepaidarrears = new Employeepaidarrears();
	$fields="hrm_employeepaidarrears.*,hrm_arrears.name";
	$join=" left join hrm_arrears on hrm_arrears.id=hrm_employeepaidarrears.arrearid ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hrm_employeepaidarrears.employeeid='$emp->id' and hrm_employeepaidarrears.month='$month' and hrm_employeepaidarrears.year='$year'";
	$employeepaidarrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();//echo $employeepaidallowances->sql;
	$rs = $employeepaidarrears->result;
	$t=0;
	while($rw=mysql_fetch_object($rs))
	  {
	  $s+=$rw->amount;
	  ?>
	  </tr>
	  <tr valign="top" style="font-size:12px; ">
	  <td ><?php echo initialCap($rw->name); ?>:</td>
	  <td align="right"><?php echo formatNumber($rw->amount); ?></td>
	  <td>&nbsp;</td>
	  <?
	      }
	  
	  ?>
      </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <?php 
	  $employeepaidallowances = new Employeepaidallowances();
	$fields="hrm_employeepaidallowances.*, hrm_allowances.name allowanceid, hrm_allowances.id allowance";
	$join=" left join hrm_allowances on hrm_allowances.id=hrm_employeepaidallowances.allowanceid ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hrm_employeepaidallowances.employeeid='$emp->id' and hrm_employeepaidallowances.month='$month' and hrm_employeepaidallowances.year='$year'";
	$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();//echo $employeepaidallowances->sql;
	$rs = $employeepaidallowances->result;
	$t=0;
	while($rw=mysql_fetch_object($rs))
	  {	  	
	  if(!empty($rw->overtimeid) and $rw->allowance==3){
	    $overtimes = new Overtimes();
	    $fields="*";
	    $join=" ";
	    $where=" where id='$rw->overtimeid' ";
	    $having="";
	    $groupby="";
	    $orderby="";
	    $overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $overtimes->sql;
	    $overtimes = $overtimes->fetchObject;
	    $rw->allowanceid=$overtimes->name."($rw->hours)";
	  }
	  $t+=$rw->amount;
	  ?>
	  </tr>
	  <tr valign="top" style="font-size:12px; ">
	  <td ><?php echo initialCap($rw->allowanceid); ?>:</td>
	  <td align="right"><?php echo formatNumber($rw->amount); ?></td>
	  <td>&nbsp;</td>
	  <?
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
      <td align="right"><?php echo formatNumber($emp->basic+$t+$s) ?></td>
	  </tr>
	  
	   <tr valign="top" style="font-size:12px; ">
	  <td colspan="3" align="left"><u>DEDUCTIONS</u></td>
	  </tr>	
	  	  
	  <?php 
	  $total=0;
	$employeepaiddeductions = new Employeepaiddeductions();
	$fields="hrm_employeepaiddeductions.*, hrm_deductions.name deductionid, hrm_deductions.id ded";
	$join=" left join hrm_deductions on hrm_deductions.id=hrm_employeepaiddeductions.deductionid ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hrm_employeepaiddeductions.employeeid='$emp->id' and hrm_employeepaiddeductions.month='$month' and hrm_employeepaiddeductions.year='$year'";
	$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res = $employeepaiddeductions->result;
	  //$res=retrievePaidEmployeeDeductions($id,$month,$year,$pay->paydate);
	  while($row=mysql_fetch_object($res)){
	  	
	  	if($row->ded==5 || $row->ded==4){
		  $loans = new Loans();
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where id='$row->loanid' ";
		  $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $loans = $loans->fetchObject;
		  
		  $row->deductionid=$loans->name;	 
		   
		    if($row->ded==4)
		    $row->deductionid=$loans->name;
		    
		  if($row->ded==5)
		    $row->deductionid=$loans->name." Interest";
	  	}
		  
		  $total+=$row->amount;
		  if($row->amount>0){
		  ?>
		  <tr valign="top" style="font-size:12px; ">
			  <td><?php echo initialCap($row->deductionid); ?>:</td>
			   <td align="right"><?php echo formatNumber($row->amount); ?></td>
			   <td>&nbsp;</td>
		  	</tr>
			   <?
		  }
	  }
	  ?>
	 
	  <?php 
	  $employeepaidsurchages = new Employeepaidsurchages();
	  $fields="hrm_employeepaidsurchages.*, hrm_surchages.name surchageid";
	  $join=" left join hrm_surchages on hrm_surchages.id=hrm_employeepaidsurchages.empsurchageid ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where hrm_employeepaidsurchages.employeeid='$emp->id' and hrm_employeepaidsurchages.month='$month' and hrm_employeepaidsurchages.year='$year'";
	  $employeepaidsurchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	  $res = $employeepaidsurchages->result;
	 // $res=retrievePaidEmployeeSurchages($pay->employeeid,$pay->month,$pay->year,$pay->paydate);
		  while($row=mysql_fetch_object($res)){
		  	$total+=$row->amount;
		  	
		  	?>
		  	 <tr valign="top" style="font-size:12px; ">
		  	<td >Surchage - <?php echo  initialCap($row->surchageid); ?>:</td>
		  	<td align="right"><?php echo formatNumber($row->amount); ?></td>
		  	<td>&nbsp;</td>
		  	</tr>
		  	
		<?  }
	  ?>
      
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >&nbsp;</td>
      <td align="right"><hr/></td>
      <td>&nbsp;</td>
	  </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >Total Deductions:</td>
	  <td>&nbsp;</td>
      <td align="right"><?php echo formatNumber($total); ?></td>
	  </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><hr/></td>
	  </tr>
	  
	  <tr valign="top" style="font-size:12px; ">
	  <td >Net Pay:</td>
	  <td>&nbsp;</td>
      <td align="right"><?php echo formatNumber($emp->basic+$t-$total); ?></td>
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
	$deductions = new Deductions();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id in(select deductionid from hrm_employeepaiddeductions where employeeid='$emp->id' and month='$month' and year='$year')";
	$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($row=mysql_fetch_object($deductions->result)){
	
	if($row->id==4){
	  $employeeloans = new Employeeloans();
	  $fields=" hrm_loans.name, hrm_employeeloans.principal ";
	  $join=" left join hrm_loans on hrm_loans.id=hrm_employeeloans.loanid ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where employeeid='$emp->id' and loanid in (select loanid from hrm_employeepaiddeductions where employeeid='$emp->id' and month='$month' and year='$year')";
	  $employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  while($rw=mysql_fetch_object($employeeloans->result)){
	    ?>
	    <tr valign="top" style="font-size:12px; ">
	      <td ><?php echo $rw->name; ?>:</td>
	      <td>&nbsp;</td>
	      <td align="right"><?php echo formatNumber($rw->principal); ?></td>
	      </tr>
	    <?php
	  }
	}
	else if($row->id==5){
	  continue;
	}
	else{
	  $employeepaiddeductions = new Employeepaiddeductions();
	  $fields=" sum(amount) amount";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where employeeid='$emp->id' and deductionid='$row->id' and year not in(2014)";
	  $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $employeepaiddeductions = $employeepaiddeductions->fetchObject;
	}
	?>
	<tr valign="top" style="font-size:12px; ">
	  <td ><?php echo $row->name; ?>:</td>
	  <td>&nbsp;</td>
	  <td align="right"><?php echo formatNumber($employeepaiddeductions->amount); ?></td>
	  </tr>
	<?php
	}
	?>
	<tr valign="top" style="font-size:12px; ">
	  <td colspan='3' align="center"><?php echo COMPANY_SLOGAN; ?></td>
	  </tr>

      </tbody>
  </table>
  
</div>
</body>
</html>
<?php 

$i=$_SESSION['i'];
while($i<3){
	redirect("print2.php?id=".$i);
	$i++;
	$_SESSION['i']=$i;
}
?>
