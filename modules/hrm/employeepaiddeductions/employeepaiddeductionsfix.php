<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaiddeductions_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../deductions/Deductions_class.php");
require_once("../employeepaidallowances/Employeepaidallowances_class.php");
require_once("../../hrm/employeeloans/Employeeloans_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeepaiddeductions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1145";//View
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;
$ob = (object)$_GET;

if(!empty($ob->deductionid)){
  $obj->deductionid=$ob->deductionid;
}

if(!empty($ob->loanid)){
  $obj->loanid=$ob->loanid;
}

if(empty($obj->action)){
  $obj->month=date("m");
  $obj->year=date("Y");
}

$obj->month=0;
$obj->year=0;
$obj->deductionid=19;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeepaiddeductions=new Employeepaiddeductions();
if(!empty($delid)){
	$employeepaiddeductions->id=$delid;
	$employeepaiddeductions->delete($employeepaiddeductions);
	redirect("employeepaiddeductions.php");
}

$deductions = new Deductions();
$fields="*";
$where=" where id='$obj->deductionid'";
$join="";
$orderby="";
$groupby="";
$having="";
$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$deductions = $deductions->fetchObject;

//Authorization.
$auth->roleid="1144";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {

	//TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
		"sScrollY": 500,
		"iDisplayLength":20,
// 		"sPaginationType": "full_numbers"
	} );
} );
</script> 
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addemployeepaiddeductions_proc.php',600,430);" value="Add Employeepaiddeductions " type="button"/></div>
<?php }?>
<form action="" method="post">
<table>
<tr>
<td><h2><?php echo $deductions->name; ?></h2></td>
</tr>
  <tr>
    <td>Month:<input type="hidden" name="deductionid" value="<?php echo $obj->deductionid; ?>"/> 
    <select name="month" id="month" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select>
    Year:
    <select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
	  $i=date("Y")-10;
	  while($i<date("Y")+10)
	  {
		?>
		  <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
		  <?
	    $i++;
	  }
	  ?>
        </select>&nbsp;
        <?php //if(!empty($obj->loanid)){?>
        <input type="checkbox" name="breakdown" value="1" <?php if($obj->breakdown==1){echo "checked";}?> />Breakdown&nbsp;
        <?php //} ?>
        <input type="submit" class="btn" name="action" value="Filter"/></td>   
  </tr>
</table>
</form>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr> <?php if($obj->deductionid==1)
		{
		?>  
			<th>#</th>
			<th>PIN of Employee</th>
			<th>Name of Employee </th>
			<th>Residential Status</th>
			<th>Type of Employee</th>
			<th>exemption certificate no</th>
			<th>Basic salary</th>
			<th>House Allowance </th>
			<th>Transport Allowance </th>
			<th>Leave Allowance</th>
			<th>Overtime Allowance</th>
			<th>Pension</th>
			<th>Directors fee</th>
			<th>Lump sum payment if any</th>
			<th>Other Allowance</th>
			<th>Total Cash Pay(A)</th>
			<th>car benefit</th>
			<th>other benefits</th>
			<th>Total non cash pay</th>
			<th>global income</th>
			<th>type of housing</th>
			<th>rent of house</th>
			<th>computed rent</th>
			<th>recovered rent</th>
			<th>net velue of house</th>
			<th>total gross pay</th>
			<th>30% cash pay</th>
			<th>actual contr.</th>
			<th>possible limit</th>
			<th>morgage interest</th>
			<th>deposit on home ownership</th>
			<th>Amount of benefit</th>
			<th>execeptions(disability)</th>
			<th>taxable pay</th>
			<th>tax payable</th>
			<th>monthly P.R</th>
			<th>Amount of In. Relief</th>
			<th>PAYE tax</th>
			<th>Self Assessed PAYE tax</th>
		<?php
	       }else if($obj->deductionid==2) { ?>
			<th>#</th>
			<th>Payroll NO</th>
			<th>Last Name</th>
			<th>Other Names</th>
			<th>ID No:</th>
			<th>NHIF NO:</th>
			<th>Amount</th>
	       
	       <?php
	       }else if($obj->deductionid==3) { ?>
			<th>#</th>
			<th>Payroll NO</th>
			<th>Names</th>
			<th>NSSF NO;</th>
			<th>Standard Amount</th>
			<th>Voluntary Amount</th>
			<th>Total</th>
			<th>ID</th>	
	       	       
	       <?php } else {?>
	                <th>#</th>
			<th>PF NUM </th>
			<th>Employee </th>
			<th>Deduction</th>
			<th>IDNO </th>
			<?php
			if(!empty($obj->loanid)){
			?>
			<th>Opening Bal</th>
			
			<?php
			if($obj->breakdown==1){
			$i=1;
			while($i<$obj->month){
			?>
			  <th><?php echo getMonth($i);?></th>
			  <th>&nbsp;</th>
			<?php
			$i++;
			}
			}
			?>
			
			<th>Amount</th>
			<th>Interest Rate</th>
			<th>Interest</th>
			<th>Closing Balance</th>
			<?
			}else{			
			?>
			<th>PIN No </th>
			<th>NSSF No </th>
			<th>NHIF No </th>
			<th>Amount </th>
			<th>Tot bal </th>
			<?php
			if($obj->breakdown==1){
			$i=1;
			while($i<$obj->month){
			?>
			  <th><?php echo getMonth($i);?></th>
			<?php
			$i++;
			}
			}
			?>
			<?php
			}
			?>
			<th>Month</th>
			<th>Paid On </th>
	       
	       <?php } ?>
<?php
//Authorization.
$auth->roleid="1146";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4172";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php  
		$i=0;
		$employeepaiddeductionss =new Employeepaiddeductions();
		$fields="hrm_employeepaiddeductions.id, hrm_employeepaiddeductions.employeepaymentid,hrm_employeepaiddeductions.paidon, hrm_deductions.name as deductionid, hrm_loans.name as loanid,  concat(concat(hrm_employees.lastname,' ',hrm_employees.middlename),' ',hrm_employees.firstname) as employeename,concat(hrm_employees.middlename,' ',hrm_employees.firstname) as names,hrm_employees.lastname,hrm_employees.pfnum,hrm_employees.id as employeeid,hrm_employees.basic,hrm_employees.idno,hrm_employees.pinno,hrm_employees.nssfno,hrm_employees.nhifno,hrm_employees.lastname,hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month, hrm_employeepaiddeductions.year, hrm_employeepaiddeductions.paidon, hrm_employeepaiddeductions.createdby, hrm_employeepaiddeductions.createdon, hrm_employeepaiddeductions.lasteditedby, hrm_employeepaiddeductions.lasteditedon, hrm_employeepaiddeductions.ipaddress";
		$join=" left join hrm_deductions on hrm_employeepaiddeductions.deductionid=hrm_deductions.id  left join hrm_loans on hrm_employeepaiddeductions.loanid=hrm_loans.id  left join hrm_employees on hrm_employeepaiddeductions.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeepaiddeductions.deductionid='$obj->deductionid' and hrm_employeepaiddeductions.month='$obj->month' and hrm_employeepaiddeductions.year='$obj->year' and hrm_employeepaiddeductions.createdon>'2016-02-26 15:21:19'";
		if(!empty($obj->loanid))
		  $where.=" and hrm_employeepaiddeductions.loanid='$obj->loanid' ";
		$employeepaiddeductionss->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $employeepaiddeductionss->sql;
		$res=$employeepaiddeductionss->result;
		$total=0;
		$totalpension=0;
		$totalnhif=0;
		$totalnssf=0;
		$totalnssfvoluntary=0;
// 		echo $employeepaiddeductions->sql;
		while($row=mysql_fetch_object($res)){	
// 		if($i==0)
		$i++;
		$date=date("Y-m-d",mktime(0,0,0,$obj->month,1,$obj->year));
		$query="select sum(amount) as tt from hrm_employeepaiddeductions where employeeid='$row->employeeid' and deductionid='$obj->deductionid' and year not in(2014) and concat(year,'-',concat(LPAD(month,2,'0'),'-',15))<'$date'";// echo $query;
		$rest=mysql_fetch_object(mysql_query($query));
	?>
		<tr>   <?php if($obj->deductionid==1)
		{
		$employeepaidallowances=new Employeepaidallowances();
		$fields="sum(hrm_employeepaidallowances.amount) as overtime";
		$join="";
		$having="";
		$where=" where employeeid='$row->employeeid' and allowanceid='3' and month='$obj->month' and year='$obj->year' ";
		$groupby="";
		$orderby="";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepaidallowances=$employeepaidallowances->fetchObject;
		$row1->overtime=$employeepaidallowances->amount;
		

		$employeepaidallowances = new Employeepaidallowances();
		$fields="sum(hrm_employeepaidallowances.amount) as amount";
		$join="";
		$having="";
		$where=" where employeeid='$row->employeeid' and allowanceid='10' and month='$obj->month' and year='$obj->year' ";
		$groupby="";
		$orderby="";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
                $employeepaidallowances=$employeepaidallowances->fetchObject;
                $travellingal = $employeepaidallowances->amount;
		
		
		$employeepaidallowances = new Employeepaidallowances();
		$fields="sum(hrm_employeepaidallowances.amount) as amount";
		$join="";
		$having="";
		$where=" where employeeid='$row->employeeid' and allowanceid='1' and month='$obj->month' and year='$obj->year' ";
		$groupby="";
		$orderby="";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepaidallowances=$employeepaidallowances->fetchObject;
                $houseall = $employeepaidallowances->amount;
		
		//select total allowances
		$employeepaidallowances = new Employeepaidallowances();
		$fields="sum(hrm_employeepaidallowances.amount) as amount";
		$join="";
		$having="";
		$where=" where employeeid='$row->employeeid' and month='$obj->month' and year='$obj->year' ";
		$groupby="";
		$orderby="";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
                $employeepaidallowances=$employeepaidallowances->fetchObject;
                $totalall = $employeepaidallowances->amount;
		
		$employeepaiddeductions = new Employeepaiddeductions();
		$fields="sum(hrm_employeepaiddeductions.amount) amount";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid in(3,17,18,29) and month='$obj->month' and year='$obj->year'";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepaiddeductions=$employeepaiddeductions->fetchObject;
		$nssf = $employeepaiddeductions->amount;
		
		$employeepaiddeductions = new Employeepaiddeductions();
		$fields="sum(hrm_employeepaiddeductions.amount) amount";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid in(32) and month='$obj->month' and year='$obj->year'";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepaiddeductions=$employeepaiddeductions->fetchObject;
		$nontax = $employeepaiddeductions->amount;
				
		$employeepaiddeductions = new Employeepaiddeductions();
		$fields="hrm_employeepaiddeductions.amount";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid='1' and month='$obj->month' and year='$obj->year'";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepaiddeductions=$employeepaiddeductions->fetchObject;
		
		$row->paye = $employeepaiddeductions->amount;
		
		$totalpension+=$nssf;
		
		?>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->pinno; ?></td>
			<td><?php echo $row->employeename; ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td align="center"><?php echo formatNumber($row->basic); ?></td>
			<td align="center"><?php echo formatNumber($houseall); ?></td>
			<td align="center"><?php echo formatNumber($travellingal); ?></td>
			<td>0</td>
			<td><?php echo $row1->overtime; ?></td>
			<td align="center"><?php echo formatNumber($nssf); ?></td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td align="center"><?php echo formatNumber($row->basic+$totalall-$nontax); ?></td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td align="center"><?php echo formatNumber($row->basic+$totalall-$nontax); ?></td>
			<td align="center"><?php echo formatNumber($row->paye+1162); ?></td>
			<td>1162</td>
			<td>0</td>
			<td align="center"><?php echo formatNumber($row->paye); ?></td>
			<td>0</td>
			
	     <?php }else if($obj->deductionid==2){ 
	              $employeepaiddeductions = new Employeepaiddeductions();
		      $fields="sum(hrm_employeepaiddeductions.amount) amount";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid=2 and month='$obj->month' and year='$obj->year'";
		      $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		      $employeepaiddeductions=$employeepaiddeductions->fetchObject;
		      $nhif = $employeepaiddeductions->amount;
		      $totalnhif+=$nhif;
		      ?>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->pfnum; ?></td>
			<td><?php echo $row->lastname; ?></td>
			<td><?php echo $row->names; ?></td>
			<td><?php echo $row->idno; ?></td>
			<td><?php echo $row->nhifno; ?></td>
			<td><?php echo $nhif; ?></td>
	       
	       <?php
	       }else if($obj->deductionid==3){  
		      $employeepaiddeductions = new Employeepaiddeductions();
		      $fields="hrm_employeepaiddeductions.amount,hrm_deductions.epays";
		      $join=" left join hrm_deductions on hrm_deductions.id=hrm_employeepaiddeductions.deductionid ";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid=3 and month='$obj->month' and year='$obj->year'";
		      $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		      $employeepaiddeductions=$employeepaiddeductions->fetchObject;		      
		      if($employeepaiddeductions->epays=="yes")
			  $nssf = ($employeepaiddeductions->amount*2);
		      else
			  $nssf = $employeepaiddeductions->amount;
		      $employeepaiddeductions = new Employeepaiddeductions();		      
		      $fields="hrm_employeepaiddeductions.amount,hrm_deductions.epays";
		      $join=" left join hrm_deductions on hrm_deductions.id=hrm_employeepaiddeductions.deductionid ";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid=29 and month='$obj->month' and year='$obj->year'";
		      $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		      $employeepaiddeductions=$employeepaiddeductions->fetchObject;
		      if($employeepaiddeductions->epays=="yes")
			  $nssfvoluntary = ($employeepaiddeductions->amount*2);
		      else
			  $nssfvoluntary = $employeepaiddeductions->amount;
		      
		      $totalnssf+=$nssf;
		      $totalnssfvoluntary+=$nssfvoluntary;
		?>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->pfnum; ?></td>
			<td><?php echo $row->employeename; ?></td>
			<td><?php echo $row->nssfno; ?></td>
			<td align="center"><?php echo formatNumber($nssf); ?></td>
			<td align="center"><?php echo formatNumber($nssfvoluntary); ?></td>
			<td align="center"><?php echo formatNumber($nssfvoluntary+$nssf); ?></td>
			<td><?php echo $row->idno; ?></td>	
			
	       	       
	       <?php
	      // }
	       }else{
	       $total+=$row->amount;
	       ?>
	               <td><?php echo $i; ?></td>
			<td><?php echo $row->pfnum; ?></td>
			<td><?php echo $row->employeename; ?></td>
			<td><?php echo $row->loanid; ?></td>
			<td><?php echo $row->idno; ?></td>
			<?php
			if(!empty($obj->loanid)){
			$date=date("Y-m-d",mktime(0,0,0,($obj->month+1),1,$obj->year));
			$employeeloans = new Employeeloans();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where hrm_employeeloans.employeeid='$row->employeeid' and  loanid='$obj->loanid' and id in(select max(id) from  hrm_employeeloans where hrm_employeeloans.employeeid='$row->employeeid' and  loanid='$obj->loanid')";
			$employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$employeeloans=$employeeloans->fetchObject;
			
			$employeepaiddeduction = new Employeepaiddeductions();
			$fields="sum(hrm_employeepaiddeductions.amount) amount";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid='$obj->deductionid' and loanid='$obj->loanid' and concat(year,'-',concat(LPAD(month,2,'0'),'-','01'))>='$date'";
			$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($row->employeeid==1) echo $employeepaiddeduction->sql;
			$employeepaiddeduction=$employeepaiddeduction->fetchObject;
			
			$employeepaiddeductions = new Employeepaiddeductions();
			$fields="hrm_employeepaiddeductions.amount amount";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid in(5) and loanid='$obj->loanid' and month='$obj->month' and year='$obj->year'";
			$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$employeepaiddeductions=$employeepaiddeductions->fetchObject;
			?>
			<td align="center"><?php echo formatNumber(($employeeloans->principal+$employeepaiddeduction->amount)+$row->amount); ?></td>
			
			<?php
			if($obj->breakdown==1){
			$x=1;
			$ln=0;
			while($x<$obj->month){
			
			$employeepaiddeduction = new Employeepaiddeductions();
			$fields="sum(hrm_employeepaiddeductions.amount) amount";
			$join="";
			$having="";
			$groupby=" group by deductionid ";
			$orderby="";
			$where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid in(4,5) and loanid='$obj->loanid' and month='$x' and year='$obj->year'";
			$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			//$employeepaiddeduction=$employeepaiddeduction->fetchObject;
			$num=$employeepaiddeduction->affectedRows;
			while($wr=mysql_fetch_object($employeepaiddeduction->result)){
			
			?>
			  <td align="right"><?php echo formatNumber($wr->amount);?></td>
			<?php
			}
			
			$g=0;
			while($g<(2-$num)){
			  ?>
			  <td align="right"><?php echo formatNumber(0);?></td>
			  <?
			  $g++;
			}
			
			$x++;
			}			
			
			}
			?>
			
			<td align="center"><?php echo formatNumber($row->amount); ?></td>
			<td align="center"><?php echo formatNumber($employeeloans->interest); ?></td>
			<td align="center"><?php echo formatNumber($employeepaiddeductions->amount); ?></td>
			<td align="center"><?php echo formatNumber($employeeloans->principal+$employeepaiddeduction->amount); ?></td>
			<?
			}else{
			?>
			<td><?php echo $row->pinno; ?></td>
			<td><?php echo $row->nssfno; ?></td>
			<td><?php echo $row->nhifno; ?></td>
			<td align="center"><?php echo formatNumber($row->amount); ?></td>
			<td style="color:red;"><?php echo formatNumber($rest->tt); ?></td>
			
			<?
			if($obj->breakdown==1){
			$x=1;
			$ln=0;
			while($x<$obj->month){
			
			$employeepaiddeduction = new Employeepaiddeductions();
			$fields="sum(hrm_employeepaiddeductions.amount) amount";
			$join="";
			$having="";
			$groupby=" group by deductionid ";
			$orderby="";
			$where=" where hrm_employeepaiddeductions.employeeid='$row->employeeid' and deductionid=$obj->deductionid and month='$x' and month>0 and year>0 and year='$obj->year'";
			$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeepaiddeduction->sql;
			//$employeepaiddeduction=$employeepaiddeduction->fetchObject;
			$num=$employeepaiddeduction->affectedRows;//echo $num;
			while($wr=mysql_fetch_object($employeepaiddeduction->result)){
			
			?>
			  <td align="right"><?php echo formatNumber($wr->amount);?></td>
			<?php
			}
			
			$g=0;
			while($g<(1-$num)){
			  ?>
			  <td align="right"><?php echo formatNumber(0);?></td>
			  <?
			  $g++;
			}
			
			$x++;
			}			
			
			}
			}
			?>
			<td><?php echo getMonth($row->month); ?>&nbsp;<?php echo $row->year; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
	       
	      <?php } ?>
<?php
//Authorization.
$auth->roleid="1146";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeepaiddeductions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a>&nbsp;&nbsp;&nbsp;<?php if(!empty($obj->loanid)){ ?><a href="javascript:;" onclick="showPopWin('../employeeloans/addemployeeloans_proc.php?id=<?php echo $employeeloans->id; ?>',600,430);">Edit C/B</a><?php } ?></td>
<?php
}
//Authorization.
$auth->roleid="4172";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeepaiddeductions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
	<tfoot>
	  <tr>
	  <?php if($obj->deductionid==1){?>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th align="center"><?php echo formatNumber($totalpension); ?></th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <?php }else if($obj->deductionid==2){ ?>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th align="center"><?php echo formatNumber($totalnhif); ?></th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	  <?php }else if($obj->deductionid==3){  ?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th align="center"><?php echo formatNumber($totalnssf); ?></th>
			<th align="center"><?php echo formatNumber($totalnssfvoluntary); ?></th>
			<th align="center"><?php echo formatNumber($totalnssf+$totalnssfvoluntary); ?></th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
	 <?php }else {?>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th align="center"><?php echo formatNumber($total); ?></th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	  <?php }?>
	  </tr>
	</tfoot>
</table>
<?php
include"../../../foot.php";
?>
