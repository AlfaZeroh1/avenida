<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedeductions_class.php");
require_once("../deductions/Deductions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeedeductions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1132";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeedeductions=new Employeedeductions();
if(!empty($delid)){
	$employeedeductions->id=$delid;
	$employeedeductions->delete($employeedeductions);
	redirect("employeedeductions.php");
}
//Authorization.
$auth->roleid="1131";//View
$auth->levelid=$_SESSION['level'];

$deductions = new Deductions();
$fields="*";
$where=" where id='$ob->deductionid'";
$join="";
$orderby="";
$groupby="";
$having="";
$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$deductions = $deductions->fetchObject;

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
		"sPaginationType": "full_numbers"
	} );
} );
</script> 
<div class="container">
<hr>
<!-- <a class="btn btn-info" onclick="showPopWin('addemployeedeductions_proc.php',600,430);">Add Employeedeductions</a> -->
<?php }?>
<h3><?php echo $deductions->name; ?></h3>
<hr>

<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Amount </th>
			<th>Deduction Type </th>
			<th>Month Assigned </th>
			<th>Year Assigned </th>
			<th>Month Moved </th>
			<th>Year Moved </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="1133";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1134";//View
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
		$fields="hrm_employeedeductions.id, hrm_deductions.name deductionid, hrm_employeedeductions.amount, hrm_deductiontypes.name as deductiontypeid, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
		$join=" left join hrm_deductiontypes on hrm_employeedeductions.deductiontypeid=hrm_deductiontypes.id  left join hrm_employees on hrm_employeedeductions.employeeid=hrm_employees.id left join hrm_deductions on hrm_deductions.id=hrm_employeedeductions.deductionid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeedeductions.deductionid='$ob->deductionid' ";
		$employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$employeedeductions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->deductiontypeid; ?></td>
			<td><?php echo $row->frommonth; ?></td>
			<td><?php echo $row->fromyear; ?></td>
			<td><?php echo $row->tomonth; ?></td>
			<td><?php echo $row->toyear; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="1133";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeedeductions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1134";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeedeductions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";
?>
