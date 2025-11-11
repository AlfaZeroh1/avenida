<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payrollconfigs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Payrollconfigs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10105";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$payrollconfigs=new Payrollconfigs();
if(!empty($delid)){
	$payrollconfigs->id=$delid;
	$payrollconfigs->delete($payrollconfigs);
	redirect("payrollconfigs.php");
}
//Authorization.
$auth->roleid="10104";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addpayrollconfigs_proc.php',600,430);" value="NEW" type="button"/></div> -->
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Parameter </th>
			<th>Type </th>
			<th>Value </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="10106";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="10107";//View
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
		$fields="fn_payrollconfigs.id, fn_payrollconfigs.name, fn_payrollconfigs.type, fn_payrollconfigs.value, fn_payrollconfigs.remarks, fn_payrollconfigs.ipaddress, fn_payrollconfigs.createdby, fn_payrollconfigs.createdon, fn_payrollconfigs.lasteditedby, fn_payrollconfigs.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$payrollconfigs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payrollconfigs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->value; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="10106";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpayrollconfigs_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="10107";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='payrollconfigs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
