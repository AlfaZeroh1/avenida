<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tschedulesexpenses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Tschedulesexpenses";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2225";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$tschedulesexpenses=new Tschedulesexpenses();
if(!empty($delid)){
	$tschedulesexpenses->id=$delid;
	$tschedulesexpenses->delete($tschedulesexpenses);
	redirect("tschedulesexpenses.php");
}
//Authorization.
$auth->roleid="2224";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addtschedulesexpenses_proc.php',600,430);" value="Add Tschedulesexpenses " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Schedule Id </th>
			<th>Expense Id </th>
			<th>Paid Thro </th>
			<th>Bank Id </th>
			<th>Cheque No. </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="2226";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2227";//View
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
		$fields="pos_tschedulesexpenses.id, pos_tschedulesexpenses.tscheduleid, pos_tschedulesexpenses.expenseid, pos_tschedulesexpenses.paidthru, pos_tschedulesexpenses.bankid, pos_tschedulesexpenses.chequeno, pos_tschedulesexpenses.amount, pos_tschedulesexpenses.remarks, pos_tschedulesexpenses.ipaddress, pos_tschedulesexpenses.createdby, pos_tschedulesexpenses.createdon, pos_tschedulesexpenses.lasteditedby, pos_tschedulesexpenses.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$tschedulesexpenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tschedulesexpenses->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->tscheduleid; ?></td>
			<td><?php echo $row->expenseid; ?></td>
			<td><?php echo $row->paidthru; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="2226";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtschedulesexpenses_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2227";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='tschedulesexpenses.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
