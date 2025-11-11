<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktrack_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Stocktrack";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$stocktrack=new Stocktrack();
if(!empty($delid)){
	$stocktrack->id=$delid;
	$stocktrack->delete($stocktrack);
	redirect("stocktrack.php");
}
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addstocktrack_proc.php', 600, 430);" value="Add Stocktrack" type="button"/></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Itemid</th>
			<th>Tid</th>
			<th>Batchno</th>
			<th>Quantity</th>
			<th>Costprice</th>
			<th>Value</th>
			<th>Discount</th>
			<th>Tradeprice</th>
			<th>Retailprice</th>
			<th>Applicabletax</th>
			<th>Expirydate</th>
			<th>Recorddate</th>
			<th>Status</th>
			<th>Remain</th>
			<th>Transaction</th>
			<th>Ipaddress</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_stocktrack.id, hos_stocktrack.itemid, hos_stocktrack.tid, hos_stocktrack.batchno, hos_stocktrack.quantity, hos_stocktrack.costprice, hos_stocktrack.value, hos_stocktrack.discount, hos_stocktrack.tradeprice, hos_stocktrack.retailprice, hos_stocktrack.applicabletax, hos_stocktrack.expirydate, hos_stocktrack.recorddate, hos_stocktrack.status, hos_stocktrack.remain, hos_stocktrack.transaction, hos_stocktrack.ipaddress, hos_stocktrack.createdby, hos_stocktrack.createdon, hos_stocktrack.lasteditedby, hos_stocktrack.lasteditedon";
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
			<td><?php echo formatNumber($row->itemid); ?></td>
			<td><?php echo formatNumber($row->tid); ?></td>
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
			<td><?php echo formatNumber($row->status); ?></td>
			<td><?php echo formatNumber($row->remain); ?></td>
			<td><?php echo $row->transaction; ?></td>
			<td><?php echo $row->ipaddress; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addstocktrack_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Edit</a></td>
			<td><a href='stocktrack.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
