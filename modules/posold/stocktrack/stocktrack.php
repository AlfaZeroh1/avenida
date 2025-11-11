<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktrack_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Stocktrack";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="728";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$stocktrack=new Stocktrack();
if(!empty($delid)){
	$stocktrack->id=$delid;
	$stocktrack->delete($stocktrack);
	redirect("stocktrack.php");
}
//Authorization.
$auth->roleid="727";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addstocktrack_proc.php',600,430);" value="Add Stocktrack " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>Item Name </th>
			<th>Document No. </th>
			<th>Batch No. </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Value </th>
			<th>Discount </th>
			<th>Trade Price </th>
			<th>Retail Price </th>
			<th>Tax </th>
			<th>Name </th>
			<th>Name </th>
			<th>Status </th>
			<th>Remain </th>
			<th>Transaction </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="729";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="730";//View
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
		$fields="inv_stocktrack.id, inv_stocktrack.itemid, inv_stocktrack.tid, inv_stocktrack.documentno, inv_stocktrack.batchno, inv_stocktrack.quantity, inv_stocktrack.costprice, inv_stocktrack.value, inv_stocktrack.discount, inv_stocktrack.tradeprice, inv_stocktrack.retailprice, inv_stocktrack.applicabletax, inv_stocktrack.expirydate, inv_stocktrack.recorddate, inv_stocktrack.status, inv_stocktrack.remain, inv_stocktrack.transaction, inv_stocktrack.createdby, inv_stocktrack.createdon, inv_stocktrack.lasteditedby, inv_stocktrack.lasteditedon, inv_stocktrack.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$stocktrack->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$stocktrack->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->tid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->batchno; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->value); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->retailprice); ?></td>
			<td><?php echo formatNumber($row->applicabletax); ?></td>
			<td><?php echo formatDate($row->expirydate); ?></td>
			<td><?php echo formatDate($row->recorddate); ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo formatNumber($row->remain); ?></td>
			<td><?php echo $row->transaction; ?></td>
			<td><?php echo $row->ipaddress; ?></td>
<?php
//Authorization.
$auth->roleid="729";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addstocktrack_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="730";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='stocktrack.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
