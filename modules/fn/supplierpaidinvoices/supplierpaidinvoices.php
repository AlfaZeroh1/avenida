<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Supplierpaidinvoices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Supplierpaidinvoices";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4730";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$supplierpaidinvoices=new Supplierpaidinvoices();
if(!empty($delid)){
	$supplierpaidinvoices->id=$delid;
	$supplierpaidinvoices->delete($supplierpaidinvoices);
	redirect("supplierpaidinvoices.php");
}
//Authorization.
$auth->roleid="4729";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addsupplierpaidinvoices_proc.php',600,430);" value="Add Supplierpaidinvoices " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Payment Voucher </th>
			<th>Invoice Number </th>
			<th>Amount </th>
<?php
//Authorization.
$auth->roleid="4731";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4732";//View
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
		$fields="fn_supplierpaidinvoices.id, fn_supplierpaidinvoices.voucherno, fn_supplierpaidinvoices.invoiceno, fn_supplierpaidinvoices.amount, fn_supplierpaidinvoices.createdby, fn_supplierpaidinvoices.createdon, fn_supplierpaidinvoices.lasteditedby, fn_supplierpaidinvoices.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$supplierpaidinvoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$supplierpaidinvoices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->voucherno; ?></td>
			<td><?php echo $row->invoiceno; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
<?php
//Authorization.
$auth->roleid="4731";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsupplierpaidinvoices_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4732";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='supplierpaidinvoices.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
