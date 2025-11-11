<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentmodes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Paymentmodes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="145";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$paymentmodes=new Paymentmodes();
if(!empty($delid)){
	$paymentmodes->id=$delid;
	$paymentmodes->delete($paymentmodes);
	redirect("paymentmodes.php");
}
//Authorization.
$auth->roleid="144";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpaymentmodes_proc.php',600,430);" value="Add Paymentmodes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Account Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="146";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="147";//View
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
		$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_acctypes.name as acctypeid, sys_paymentmodes.remarks";
		$join=" left join sys_acctypes on sys_paymentmodes.acctypeid=sys_acctypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$paymentmodes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->acctypeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="146";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpaymentmodes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="147";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='paymentmodes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
