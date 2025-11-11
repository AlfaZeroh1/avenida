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
require_once("../../hrm/nhifs/Nhifs_class.php");
require_once("../../hrm/nssfs/Nssfs_class.php");
require_once("../../hrm/loans/Loans_class.php");
require_once("../../hrm/employeeloans/Employeeloans_class.php");
require_once '../../hrm/surchages/Surchages_class.php';
require_once '../../hrm/employeesurchages/Employeesurchages_class.php';
require_once("../../hrm/departments/Departments_class.php");
require_once '../../sys/paymentmodes/Paymentmodes_class.php';
require_once '../../fn/banks/Banks_class.php';
require_once '../../hrm/employeepaidsurchages/Employeepaidsurchages_class.php';
require_once("../../hrm/overtimes/Overtimes_class.php");
require_once("../../hrm/employeepaidarrears/Employeepaidarrears_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeepayments";
//connect to db
$db=new DB();
$obj = (object)$_POST;

$shps = array();
$_SESSION['shps']=$shps;

if(!empty($obj->action)){
	$inner=100;
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
else 
{
$inner=150;
}
if(empty($obj->action)){
	$obj->month=date("m");
	$obj->year=date("Y");
	$obj->paidon=date('Y-m-d');
	
	$obj->fromdate= date("Y-m-1", mktime(0, 0, 0, $obj->month, 1, $obj->year));
	$obj->todate = date("Y-m-t", mktime(0, 0, 0, $obj->month, 1, $obj->year)); 
}
//Authorization.
$auth->roleid="4262";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

if($obj->action=="Send Payslip via E-mail"){
	$employee = new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) employeeid, hrm_employees.gender, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_nationalitys.name as nationalityid, hrm_countys.name as countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employeebanks.name as bankid, hrm_bankbranches.name as bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employeepayments.basic as basic, hrm_assignments.name as assignmentid, hrm_grades.name as gradeid, hrm_employeestatuss.name as statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join=" left join hrm_nationalitys on hrm_employees.nationalityid=hrm_nationalitys.id  left join hrm_countys on hrm_employees.countyid=hrm_countys.id  left join hrm_employeebanks on hrm_employees.employeebankid=hrm_employeebanks.id  left join hrm_bankbranches on hrm_employees.bankbrancheid=hrm_bankbranches.id  left join hrm_assignments on hrm_employees.assignmentid=hrm_assignments.id  left join hrm_grades on hrm_employees.gradeid=hrm_grades.id left join hrm_employeestatuss on hrm_employees.statusid=hrm_employeestatuss.id left join hrm_employeepayments on hrm_employees.id=hrm_employeepayments.employeeid  ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where  hrm_employees.id in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') ".$wh;
	$employee->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employee->sql;
	$res=$employee->result;
	$emp=array();
	$i=0;
	while($row=mysql_fetch_object($res)){
		if(isset($_POST[$row->id]))
			$emp[$i]=$row->id;
	}
	
	if(count($emp)>0){
		$_SESSION['emp']=$emp;
	}
	
	redirect("use_gmail.php?year=".$obj->year."&month=".$obj->month,"new");
}
?>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
TableTools.DEFAULTS.aButtons = [ "copy", "csv", "xls","pdf" ];
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"sScrollY": 500,
		"bJQueryUI": true,
 		"iDisplayLength":200,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 1000,
// 		"sScrollX": "100%",
// 		"aaSorting":[[3,"asc"]],
		"sScrollXInner": "<?php echo $inner; ?>%",
		"bScrollCollapse": true,
		"aoColumnDefs": [
		                 { "bSortable": false, "aTargets": [ 1 ] }
		               ],
		"fnRowCallback": function( nRow, aaData, iDisplayIndex, oSettings ) {
			/* Need to redo the counters if filtered or sorted */
			if ( oSettings.bSorted || oSettings.bFiltered ) {
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ ) {
					this.fnUpdate( i+1, oSettings.aiDisplay[i], 0, false, false );
				}
			}
			for(var i=9; i<aaData.length;i++){
			if(i<9)
			  $('td:eq('+i+')', nRow).html(aaData[i]);
			else
			  $('td:eq('+i+')', nRow).html(aaData[i]).formatCurrency().attr('align','right');
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL");
			var total=[];
			//var k=0;
			for(var i=0; i<aaData.length; i++){
			  //var k = aaData[i].length;
			  
			  for(var j=9; j<aaData[i].length; j++){
			    if(aaData[i][j]=='')
			      aaData[i][j]=0;			      
			      
			      if(i==0)
				total[j]=0;
				
				total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);	//alert(parseFloat(aaData[i][j]));	
			  }
			  
			}
			
			for(var i=9; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]).formatCurrency().attr('align','right');
			}
		}
	} );
$('#tbl_next').click();
$('#tbl_previous').click();
} );

function selectAll(str)
{
	if(str.checked)
	{//check all checkboxes under it
		
		<?php
		$employees = new Employees();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.statusid=1 and hrm_employees.id in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year')";
		$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		while($rw=mysql_fetch_object($employees->result))
		{			
		?>
		if(document.getElementById("<?php echo $rw->id; ?>")){
			//alert("Success <?php echo $rw->id; ?>");
			document.getElementById("<?php echo $rw->id; ?>").checked=true;
			setEmployee("<?php echo $rw->id; ?>");
		}
		<?php		
		}
		?>
	}
	else
	{
		//uncheck all checkboxes under it
		<?php
		$employees = new Employees();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.id in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year')";
		$employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		while($rw=mysql_fetch_object($employees->result))
		{
		?>
		document.getElementById("<?php echo $rw->id; ?>").checked=false;
		setEmployee("<?php echo $rw->id; ?>");
		<?php
		}
		?>
	}
}

function setEmployee(id){
  //document.getElementById("quantity"+id).disable=false;
    
  if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {//alert(xmlhttp.responseText);
    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  var url="sets.php?id="+id+"&checked="+$("#"+id).is(':checked');
  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}


function Clickheretoprint(task)
{ 
	var msg;
	
	msg="Do you want to print Pay slips?";
	//var ans=confirm(msg);
	var ans = true;
	if(ans)
	{
		var elements = document.getElementsByTagName("input");
		for(i=0;i<elements.length;i++){
			if(elements[i].type=="checkbox" && !isNaN(elements[i].value)  && elements[i].checked==true){
				var id=elements[i].value;
				if(task=="print")
					poptastic("print2.php?id="+id+"&month=<?php echo $obj->month; ?>&year=<?php echo $obj->year; ?>",650,400);
				else
					poptastic("php.php?id="+id+"&month=<?php echo $obj->month; ?>&year=<?php echo $obj->year; ?>",650,400);
			}
		}
	}
}
</script>
		<form action="employeepaidpayments.php" method="post">
<div style="float:center;">

<table align="center" id="tasktable">
  <tr>
    <td><div align="right"></div>
        <strong>Year:</strong>
        <select name="year">
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
        </select>
      &nbsp;&nbsp; <strong>Month</strong>:
      <select name="month">
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
      &nbsp;
        From :<input type="text" name="fromdate" class="date_input" size="12" readonly value="<?php echo $obj->fromdate; ?>"/>&nbsp;
        To :<input type="text" name="todate" class="date_input" size="12" readonly value="<?php echo $obj->todate; ?>"/>
       &nbsp;<br/>
      <strong>Bank:</strong>
    <select name="bankid">
    <option value="">Select...</option>
    <?php
    $banks=new Banks();
    $i=0;
    $fields="hrm_banks.id, hrm_banks.code, hrm_banks.name, hrm_banks.remarks, hrm_banks.createdby, hrm_banks.createdon, hrm_banks.lasteditedby, hrm_banks.lasteditedon";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
    $res=$banks->result;
    while($row=mysql_fetch_object($res))
    {
    ?>
    <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->bankid){echo"selected";}?>><?php echo $row->name; ?></option>
    <?
    }
    ?>
    
    
    </select>   
    &nbsp;
    
    Department:
    <?php
    
  $departments=new Departments();
  $i=0;
  $fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $res=$departments->result;
  
    ?>
    <select name="departmentid" class="input-small">
  <option value="">All</option>
  <?php
	while($row=mysql_fetch_object($res))
	{
	?>
	<option value="<?php echo $row->id; ?>" <?php if($obj->departmentid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
	<?
	}
  ?>
  </select>
    &nbsp;
    Emp Type:
    <select name="type" class="input-small">
      <option value="">Select...</option>
      <option value="1" <?php if($obj->type==1){echo"selected";}?>>Permanent</option>
      <option value="2" <?php if($obj->type==2){echo"selected";}?>>Casual</option>
    </select>&nbsp;
  
  <input type="checkbox" name="allowances" value="1" <?php if($obj->allowances==1){echo "checked";}?> /> Allowances&nbsp;
  <input type="checkbox" name="deductions" value="1" <?php if($obj->deductions==1){echo "checked";}?>/> Deductions
  <?php if(empty($paydate)){?>
      <input type="submit" name="action" id="action" value="Load" />
      <?php }?>
      </td>
  </tr>
  
</table>

</div>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th><input type="checkbox" onclick="selectAll(this);"/>All</th>
			<th>Employee </th>
			<th>Position </th>
			<th>Bank (if Paid Via Bank) </th>
			<th>Bank Branch </th>
			<th>Clearing Code </th>
			<th>Bank Account </th>
			<th>Reference </th>
			<th>Basic </th>
			<?php 
			if($obj->allowances==1){
			$allowances=new Allowances();
			$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowancetypes.name as allowancetypeid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
			$join=" left join hrm_allowancetypes on hrm_allowances.allowancetypeid=hrm_allowancetypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where  hrm_allowances.status='active' ";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$allowances->result;
			while($row=mysql_fetch_object($res)){
			if($row->id!=3){
			?>
				<th><?php echo initialCap($row->name); ?></th>
			<?php 
			}
			
			else{
			  $overtimes = new Overtimes();
					  $fields="*";
					  $join=" ";
					  $where=" ";
					  $having="";
					  $groupby="";
					  $orderby="";
					  $overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					  while($ov=mysql_fetch_object($overtimes->result)){
					  ?>
				<th><?php echo initialCap($ov->name); ?></th>
			<?php 
					  }
			}
			}
			}
			?>
			<th>Total Allowances</th>
			<th>Gross Pay</th>
			<?php 
			if($obj->deductions==1){
			$deductions=new Deductions();
			$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductiontypes.name as deductiontypeid, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.amount, hrm_deductions.overall, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
			$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where  hrm_deductions.status='active' and hrm_deductions.id not in(4,5)";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$deductions->result;
			while($row=mysql_fetch_object($res)){
			?>
				<th><?php echo $row->name; ?></th>
			<?php
			}
			
			$loans = new Loans();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" ";
			$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$loans->result;
			while($row=mysql_fetch_object($res)){
				?>
						<th><?php echo $row->name; ?></th>						
						<th><?php echo $row->name; ?> Interest</th>
					<?php
					}
					
					$surchages = new Surchages();
					$fields="*";
					$join="";
					$having="";
					$groupby="";
					$orderby="";
					$where=" ";
					$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$res=$surchages->result;
					while($row=mysql_fetch_object($res)){
						?>
							<th><?php echo $row->name; ?></th>		
						<?php
						}
			}
			
			?>
			<th>Total Deductions</th>			
			<th>Net Pay</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hrm_employees.id, hrm_employees.pfnum, concat(hrm_employees.pfnum, ' ', concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname)) employeeid, hrm_employees.gender, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_nationalitys.name as nationalityid, hrm_countys.name as countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employeebanks.name as employeebankid, hrm_bankbranches.name as bankbrancheid, hrm_employees.bankacc, hrm_bankbranches.code clearingcode, hrm_employees.ref, hrm_employeepayments.basic as basic, hrm_assignments.name as assignmentid, hrm_grades.name as gradeid, hrm_employeestatuss.name as statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
		$join=" left join hrm_nationalitys on hrm_employees.nationalityid=hrm_nationalitys.id  left join hrm_countys on hrm_employees.countyid=hrm_countys.id  left join hrm_employeebanks on hrm_employees.employeebankid=hrm_employeebanks.id  left join hrm_bankbranches on hrm_employees.bankbrancheid=hrm_bankbranches.id  left join hrm_assignments on hrm_employees.assignmentid=hrm_assignments.id  left join hrm_grades on hrm_employees.gradeid=hrm_grades.id  left join hrm_employeestatuss on hrm_employees.statusid=hrm_employeestatuss.id left join hrm_employeepayments on hrm_employeepayments.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby=" order by pfnum asc";
		$where=" where  hrm_employees.id in(select employeeid from hrm_employeepayments where month='$obj->month' and year='$obj->year') and hrm_employeepayments.month='$obj->month' and hrm_employeepayments.year='$obj->year' and (hrm_employeepayments.fromdate between '$obj->fromdate' and '$obj->todate' or hrm_employeepayments.todate between '$obj->fromdate' and '$obj->todate') ".$wh;
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employees->sql;
		$res=$employees->result;
		$totalbasic=0;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input name="<?php echo $row->id; ?>" type="checkbox" onclick="setEmployee(this.value);" id="<?php echo $row->id; ?>"  value="<?php echo $row->id; ?>"  /></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->assignmentid; ?></td>
			<td><?php echo $row->employeebankid; ?></td>
			<td><?php echo $row->bankbrancheid; ?></td>
			<td><?php echo $row->clearingcode; ?></td>
			<td><?php echo $row->bankacc; ?></td>
			<td><?php echo $row->ref; ?></td>
			<td align="right"><?php echo formatNumber($row->basic); ?></td>
			<?php 
			$totalallowances = 0;
			$taxable=$row->basic;
			$totalbasic+=$row->basic;
			$allowances=new Allowances();
			$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowancetypes.name as allowancetypeid, hrm_allowancetypes.repeatafter, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
			$join=" left join hrm_allowancetypes on hrm_allowances.allowancetypeid=hrm_allowancetypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			//to ensure that the allowance is active
			$where=" where  hrm_allowances.status='active'";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($allowances->result)){
			$allowance=0;
				//check allowances that affect all
				if($rw->id!=3){
					  
					$employeepaidallowances=new Employeepaidallowances();
					$fields=" sum(amount) amount";
					$join=" ";
					$having="";
					$groupby="";
					$orderby="";
					//checks if allowance is still active
					$where=" where hrm_employeepaidallowances.employeeid=$row->id and hrm_employeepaidallowances.allowanceid=$rw->id and hrm_employeepaidallowances.month='$obj->month' and hrm_employeepaidallowances.year='$obj->year' ";
					$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
					$employeepaidallowances = $employeepaidallowances->fetchObject;
					$allowance=$employeepaidallowances->amount;
			    
				
			$totalallowances+=$allowance;
			if($obj->allowances==1){
			?>
				<td align="right"><?php echo formatNumber($allowance);  ?></td>
			<?php 
			}
			}
			else{
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
					    $employeepaidallowances=new Employeepaidallowances();
					$fields="sum(amount) amount";
					$join=" ";
					$having="";
					$groupby="";
					$orderby="";
					//checks if allowance is still active
					$where=" where hrm_employeepaidallowances.employeeid=$row->id and hrm_employeepaidallowances.allowanceid=$rw->id and hrm_employeepaidallowances.overtimeid='$ov->id' and hrm_employeepaidallowances.month='$obj->month' and hrm_employeepaidallowances.year='$obj->year' ";
					$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
					$employeepaidallowances = $employeepaidallowances->fetchObject;
					$allowance=$employeepaidallowances->amount;
			    
				
					$totalallowances+=$allowance;
					if($obj->allowances==1){
					?>
						<td align="right"><?php echo formatNumber($allowance);  ?></td>
					<?php 
					}
					}
			}
			}
			$totalarrears=0;
			$employeepaidarrears = new Employeepaidarrears();
					  $fields="sum(amount) as amount";
					  $join="";
					  $where=" where hrm_employeepaidarrears.employeeid=$row->id and hrm_employeepaidarrears.month='$obj->month' and hrm_employeepaidarrears.year='$obj->year' ";
					  $having="";
					  $groupby="";
					  $orderby="";
					  $employeepaidarrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					  while($arreas=mysql_fetch_object($employeepaidarrears->result)){
					  $arreas->amount;
					  $totalarrears=$arreas->amount;
					  }
			$grosspay=$row->basic+$totalallowances+$totalarrears;
			?>
			<td align="right"><?php echo formatNumber($totalallowances); ?></td>
			<td align="right"><?php echo formatNumber($grosspay); ?></td>
			<?php 
			$totaldeductions = 0;
			$deductions=new Deductions();
			$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.amount, hrm_deductiontypes.name as deductiontypeid, hrm_deductiontypes.repeatafter, hrm_deductions.overall, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
			$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			//to ensure that the deduction is active
			$where=" where  hrm_deductions.status='active' and hrm_deductions.id not in(4,5)";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($rw=mysql_fetch_object($deductions->result)){
			$deduction=0;
			$now=getDates($obj->year, $obj->month, 01);
				//check deductions that affect all
				
					$employeepaiddeductions=new Employeepaiddeductions();
					$fields="*";
					$join="";
					$having="";
					$groupby="";
					$orderby="";
					//checks if deduction is still active
					$where=" where hrm_employeepaiddeductions.employeeid=$row->id and hrm_employeepaiddeductions.deductionid=$rw->id and hrm_employeepaiddeductions.month='$obj->month' and hrm_employeepaiddeductions.year='$obj->year' ";
					$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$employeepaiddeductions = $employeepaiddeductions->fetchObject;
					
					$deduction = $employeepaiddeductions->amount;
					
			$totaldeductions+=$deduction;
			if($obj->deductions==1){
			?>
				<td align="right"><?php echo formatNumber($deduction);  ?></td>
			<?php 
			}
			}
			$loans = new Loans();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where="";
			$loans->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($wr=mysql_fetch_object($loans->result)){
				$employeepaiddeductions=new Employeepaiddeductions();
				$fields="hrm_employeepaiddeductions.id, hrm_employeepaiddeductions.deductionid as deductionid, hrm_employeepaiddeductions.loanid, sum(hrm_employeepaiddeductions.amount) amount";
				$join="  ";
				$having="";
				$groupby=" group by deductionid, loanid";
				$orderby="";
				//checks if deduction is still active
				$where=" where hrm_employeepaiddeductions.employeeid=$row->id and hrm_employeepaiddeductions.loanid=$wr->id and hrm_employeepaiddeductions.deductionid in(4) and hrm_employeepaiddeductions.month='$obj->month' and hrm_employeepaiddeductions.year='$obj->year'";
				$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();//if($row->id==1)echo $employeepaiddeductions->sql."<br/>";
				if($employeepaiddeductions->affectedRows>0){
					while($rw=mysql_fetch_object($employeepaiddeductions->result)){					
						
						$deduction=$rw->amount;
							$totaldeductions+=$deduction;
						if($obj->deductions==1 and $rw->deductionid==4){
							
							?>
							<td align="right"><?php echo formatNumber($deduction);  ?></td>
							<?php 
							}
					}
				}
				else{
					if($obj->deductions==1){
					?>
					<td align="right"><?php echo formatNumber(0);  ?></td>
					<?php 
					}
				}
				
				$employeepaiddeductions=new Employeepaiddeductions();
				$fields="hrm_employeepaiddeductions.id, hrm_employeepaiddeductions.deductionid as deductionid, hrm_employeepaiddeductions.loanid, sum(hrm_employeepaiddeductions.amount) amount";
				$join="  ";
				$having="";
				$groupby=" group by deductionid, loanid";
				$orderby="";
				//checks if deduction is still active
				$where=" where hrm_employeepaiddeductions.employeeid=$row->id and hrm_employeepaiddeductions.loanid=$wr->id and hrm_employeepaiddeductions.deductionid in(5) and hrm_employeepaiddeductions.month='$obj->month' and hrm_employeepaiddeductions.year='$obj->year'";
				$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo mysql_error();if($row->id==1)echo $employeepaiddeductions->sql."<br/>";
				if($employeepaiddeductions->affectedRows>0){
					while($rw=mysql_fetch_object($employeepaiddeductions->result)){					
						
						$deduction=$rw->amount;
							$totaldeductions+=$deduction;
						if($obj->deductions==1 and $rw->deductionid==5){
							
							?>
							<td align="right"><?php echo formatNumber($deduction);  ?></td>
							<?php 
							}
						
					}
				}
				else{
					if($obj->deductions==1){
					?>
					<td align="right"><?php echo formatNumber(0);  ?></td>
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
				$employeepaidsurchages = new Employeepaidsurchages();
				$fields="sum(amount) amount";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where employeeid='$row->id' and empsurchageid='$wr->id' and month='$obj->month' and year='$obj->year' ";echo mysql_error();
				$employeepaidsurchages->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				if($employeepaidsurchages->affectedRows>0){
					while($rw=mysql_fetch_object($employeepaidsurchages->result)){
						$deduction=$rw->amount;
						$totaldeductions+=$deduction;
						if($obj->deductions==1){
						?>
						<td align="right"><?php echo formatNumber($deduction);  ?></td>
						<?php 
						}
					}
				}
				else{
					if($obj->deductions==1){
				?>
					<td align="right"><?php echo formatNumber(0);  ?></td>
					<?php 
 					}
				}
			}
			$netpay=$grosspay-$totaldeductions;
			?>
			<td align="right"><?php echo formatNumber($totaldeductions); ?></td>
			<td align="right"><?php echo formatNumber(round($netpay,-1));?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
	<tfoot>
	<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th>&nbsp; </th>
			<th><?php echo $totalbasic; ?></th>
			<?php 
			if($obj->allowances==1){
			$allowances=new Allowances();
			$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowancetypes.name as allowancetypeid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
			$join=" left join hrm_allowancetypes on hrm_allowances.allowancetypeid=hrm_allowancetypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where  hrm_allowances.status='active'";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$allowances->result;
			while($row=mysql_fetch_object($res)){
			?>
				<th><?php echo initialCap($row->name); ?></th>
			<?php 
			}
			}
			?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<?php 
			if($obj->deductions==1){
			$deductions=new Deductions();
			$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductiontypes.name as deductiontypeid, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.amount, hrm_deductions.overall, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
			$join=" left join hrm_deductiontypes on hrm_deductions.deductiontypeid=hrm_deductiontypes.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where  hrm_deductions.status='active'";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$deductions->result;
			while($row=mysql_fetch_object($res)){
			
			
			if($row->id==4){
			  $loans = new Loans();
			  $fields="*";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $where=" ";
			  $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $ress=$loans->result;
			  while($roww=mysql_fetch_object($ress)){
				  ?>
						  <th>&nbsp;</th>						
						  <th>&nbsp;</th>
					  <?php
					  }
			 }
			 elseif($row->id==5){
			  continue;
			 }
			 else{
			?>
				<th>&nbsp;</th>
			<?php
			}
			}
			
			
					
					$surchages = new Surchages();
					$fields="*";
					$join="";
					$having="";
					$groupby="";
					$orderby="";
					$where=" ";
					$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$res=$surchages->result;
					while($row=mysql_fetch_object($res)){
						?>
							<th><?php echo $row->name; ?></th>		
						<?php
						}
			}
			
			?>
			<th>&nbsp;</th>			
			<th>&nbsp;</th>
		</tr>
	</tfoot>
</table>
<table align="center">
<tr>
	<td><input type="button" name="action" value="Print Payslip" onclick="Clickheretoprint('print');"/></td>
	<td><input type="submit" name="action" value="Send Payslip via E-mail" /></td>
</tr>
</table>
</form>
<?php
include"../../../foot.php";
?>
