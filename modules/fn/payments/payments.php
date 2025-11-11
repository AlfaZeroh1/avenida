<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Payments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9007";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$payments=new Payments();
if(!empty($delid)){
	$payments->id=$delid;
	$payments->delete($payments);
	redirect("payments.php");
}
//Authorization.
$auth->roleid="9006";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpayments_proc.php',600,430);" value="Add Payments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Other Payment </th>
			<th>Remarks </th>
			<th>Other Payments </th>
<?php
//Authorization.
$auth->roleid="9008";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9009";//View
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
		$fields="fn_payments.id, fn_payments.name, fn_payments.remarks, sys_acctypes.name as acctypeid, fn_payments.ipaddress, fn_payments.createdby, fn_payments.createdon, fn_payments.lasteditedby, fn_payments.lasteditedon";
		$join=" left join sys_acctypes on fn_payments.acctypeid=sys_acctypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$payments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->acctypeid; ?></td>
<?php
//Authorization.
$auth->roleid="9008";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpayments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9009";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='payments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
