<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Orderpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Orderpayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11904";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$orderpayments=new Orderpayments();
if(!empty($delid)){
	$orderpayments->id=$delid;
	$orderpayments->delete($orderpayments);
	redirect("orderpayments.php");
}
//Authorization.
$auth->roleid="11903";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addorderpayments_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Order </th>
			<th>Paid On </th>
			<th>Amount Paid </th>
			<th>Amount Given </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="11905";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11906";//Add
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
		$fields="pos_orderpayments.id, pos_orderpayments.orderid, pos_orderpayments.paidon, pos_orderpayments.amount, pos_orderpayments.amountgiven, pos_orderpayments.remarks, pos_orderpayments.ipaddress, pos_orderpayments.createdby, pos_orderpayments.createdon, pos_orderpayments.lasteditedby, pos_orderpayments.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$orderpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$orderpayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->orderid; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo formatNumber($row->amountgiven); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="11905";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addorderpayments_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11906";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='orderpayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
