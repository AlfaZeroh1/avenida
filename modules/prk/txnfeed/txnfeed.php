<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Txnfeed_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Txnfeed";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8324";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$txnfeed=new Txnfeed();
if(!empty($delid)){
	$txnfeed->id=$delid;
	$txnfeed->delete($txnfeed);
	redirect("txnfeed.php");
}
//Authorization.
$auth->roleid="8323";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addtxnfeed_proc.php',600,430);" value="Add Txnfeed " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="8325";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8326";//Add
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
		$fields="prk_txnfeed.txnid, prk_txnfeed.Vehicle_reg, prk_txnfeed.slot_id, prk_txnfeed.Mpesa_sender, prk_txnfeed.mpesa_trx_time";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$txnfeed->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$txnfeed->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->txnid; ?></td>
			<td><?php echo $row->Vehicle_reg; ?></td>
			<td><?php echo $row->slot_id; ?></td>
			<td><?php echo $row->Mpesa_sender; ?></td>
			<td><?php echo $row->mpesa_trx_time; ?></td>
<?php
//Authorization.
$auth->roleid="8325";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtxnfeed_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8326";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='txnfeed.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
