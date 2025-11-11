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
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addemployeedeductions_proc.php',600,430);">Add Employeedeductions</a>
<?php }?>
<hr>
<h2><?php echo $deductions->name; ?></h2>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Amount </th>
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
		$employees = new Employees();
		$fields="*";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" ";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><input type="text" name="" onchange="addMatrix(this,<?php echo $row->id; ?>,<?php echo $ob->deductionid; ?>,'amount',this.value,'<?php echo $sarr; ?>');"></td>
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
