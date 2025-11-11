<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Items_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Items";
//connect to db
$db=new DB();
include"../../../head.php";

$delid=$_GET['delid'];
$items=new Items();
if(!empty($delid)){
	$items->id=$delid;
	$items->delete($items);
	redirect("items.php");
}
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('additems_proc.php', 600, 430);" value="Add Items" type="button"/></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Code</th>
			<th>Name</th>
			<th>Manufacturer</th>
			<th>Strength</th>
			<th>Costprice</th>
			<th>Discount</th>
			<th>Tradeprice</th>
			<th>Retailprice</th>
			<th>Applicabletax</th>
			<th>Reorderlevel</th>
			<th>Quantity</th>
			<th>Status</th>
			<th>Expirydate</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hos_items.id, hos_items.code, hos_items.name, hos_items.manufacturer, hos_items.strength, hos_items.costprice, hos_items.discount, hos_items.tradeprice, hos_items.retailprice, hos_items.applicabletax, hos_items.reorderlevel, hos_items.quantity, hos_items.status, hos_items.expirydate, hos_items.createdby, hos_items.createdon, hos_items.lasteditedby, hos_items.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($_GET['departmentid']))
			$where=" where departmentid='".$_GET['departmentid']."'";
		else
			$where="";
		$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $sql;
		$res=$items->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->manufacturer; ?></td>
			<td><?php echo $row->strength; ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->retailprice); ?></td>
			<td><?php echo $row->applicabletax; ?></td>
			<td><?php echo formatNumber($row->reorderlevel); ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->status); ?></td>
			<td><?php echo formatDate($row->expirydate); ?></td>
			<td><a href="javascript:;" onclick="showPopWin('additems_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Edit</a></td>
			<td><a href='items.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
