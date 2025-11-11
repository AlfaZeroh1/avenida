<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Imprestaccountemployees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Imprestaccountemployees";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8124";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$imprestaccountemployees=new Imprestaccountemployees();
if(!empty($delid)){
	$imprestaccountemployees->id=$delid;
	$imprestaccountemployees->delete($imprestaccountemployees);
	redirect("imprestaccountemployees.php");
}
//Authorization.
$auth->roleid="8123";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addimprestaccountemployees_proc.php',600,430);" value="Add Imprestaccountemployees " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Imprest Account </th>
			<th>Owned By </th>
			<th>Added On </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8125";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8126";//Add
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
		$fields="fn_imprestaccountemployees.id, fn_imprestaccounts.name as imprestaccountid, hrm_employees.name as employeeid, fn_imprestaccountemployees.addedon, fn_imprestaccountemployees.remarks, fn_imprestaccountemployees.ipaddress, fn_imprestaccountemployees.createdby, fn_imprestaccountemployees.createdon, fn_imprestaccountemployees.lasteditedby, fn_imprestaccountemployees.lasteditedon";
		$join=" left join fn_imprestaccounts on fn_imprestaccountemployees.imprestaccountid=fn_imprestaccounts.id  left join hrm_employees on fn_imprestaccountemployees.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$imprestaccountemployees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$imprestaccountemployees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->imprestaccountid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->addedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8125";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addimprestaccountemployees_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8126";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='imprestaccountemployees.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
