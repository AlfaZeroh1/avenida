<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transfers_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
// redirect("addtransfers_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Transfers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7495";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$transfers=new Transfers();
if(!empty($delid)){
	$transfers->id=$delid;
	$transfers->delete($transfers);
	redirect("transfers.php");
}
//Authorization.
$auth->roleid="7494";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <a href='addtransfers_proc.php'>New Transfers</a></div> -->
<?php }?>

<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Transfer No </th>
			<th>Item</th>
			<th>Quantity</th>
			<th>From</th>
			<th>To</th>
			<th>Remarks </th>
			<th>Transfered On </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="7496";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7497";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<th>&nbsp;</th> -->
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="inv_transfers.id,inv_transferdetails.transferid, sum(inv_transferdetails.quantity) as quantity, inv_transfers.documentno,inv_items.name as item, sys_branches.name as brancheid, sys_branches2.name as tobrancheid, inv_transfers.remarks, inv_transfers.transferedon, inv_transfers.status, inv_transfers.ipaddress, inv_transfers.createdby, inv_transfers.createdon, inv_transfers.lasteditedby, inv_transfers.lasteditedon, sum(inv_transferdetails.quantity-case when inv_transferdetails.quantityrec is null then 0 else inv_transferdetails.quantityrec end) status";
		$join=" left join sys_branches on inv_transfers.brancheid=sys_branches.id  left join sys_branches sys_branches2 on inv_transfers.tobrancheid=sys_branches2.id left join inv_transferdetails on inv_transfers.id=inv_transferdetails.transferid left join inv_items on inv_items.id=inv_transferdetails.itemid ";
		$having=" having status>0 ";
		$groupby=" group by inv_transferdetails.transferid ";
		$orderby="";
		$where="";
// 		if($_SESSION['brancheid']!=26){
// 		  $where=" where inv_transfers.tobrancheid='".$_SESSION['tobrancheid']."' ";
// 		}
		$transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$transfers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->item; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->tobrancheid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatDate($row->transferedon); ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="7496";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
//if($row->status!=1)
//{
?>
			<td><a href="addtransfers_proc.php?documentno=<?php echo $row->documentno; ?>&receive=1">Receive</a></td>
<?php
}

//Authorization.
$auth->roleid="7497";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){

?>
<!-- 			<td><a href='transfers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> -->
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
