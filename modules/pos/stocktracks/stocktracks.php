<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktracks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Stocktracks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="3760";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$stocktracks=new Stocktracks();
if(!empty($delid)){
	$stocktracks->id=$delid;
	$stocktracks->delete($stocktracks);
	redirect("stocktracks.php");
}
//Authorization.
$auth->roleid="3759";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addstocktracks_proc.php',600,430);" value="Add Stocktracks " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th> </th>
			<th>Document No </th>
			<th>Batch No </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Value </th>
			<th>Discount </th>
			<th>Trade Price </th>
			<th>Retail Price </th>
			<th>Applicable Tax </th>
			<th>Expiry Date </th>
			<th>Record Date </th>
			<th>Status </th>
			<th>Remain </th>
			<th>Transaction </th>
<?php
//Authorization.
$auth->roleid="3761";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="3762";//View
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
		$fields="pos_stocktracks.id, pos_items.name as itemid, pos_stocktracks.tid, pos_stocktracks.documentno, pos_stocktracks.batchno, pos_stocktracks.quantity, pos_stocktracks.costprice, pos_stocktracks.value, pos_stocktracks.discount, pos_stocktracks.tradeprice, pos_stocktracks.retailprice, pos_stocktracks.tax, pos_stocktracks.expirydate, pos_stocktracks.recorddate, pos_stocktracks.status, pos_stocktracks.remain, pos_stocktracks.transaction, pos_stocktracks.createdby, pos_stocktracks.createdon, pos_stocktracks.lasteditedby, pos_stocktracks.lasteditedon, pos_stocktracks.ipaddress";
		$join=" left join pos_items on pos_stocktracks.itemid=pos_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$stocktracks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$stocktracks->result;
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
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatDate($row->expirydate); ?></td>
			<td><?php echo formatDate($row->recorddate); ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo formatNumber($row->remain); ?></td>
			<td><?php echo $row->transaction; ?></td>
<?php
//Authorization.
$auth->roleid="3761";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addstocktracks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="3762";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='stocktracks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
