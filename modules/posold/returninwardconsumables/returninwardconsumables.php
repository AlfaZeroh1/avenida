<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Invoiceconsumables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Invoiceconsumables";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9385";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$invoiceconsumables=new Invoiceconsumables();
if(!empty($delid)){
	$invoiceconsumables->id=$delid;
	$invoiceconsumables->delete($invoiceconsumables);
	redirect("invoiceconsumables.php");
}
//Authorization.
$auth->roleid="9384";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addinvoiceconsumables_proc.php',600,430);" value="Add Invoiceconsumables " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Consumable </th>
			<th>UoM </th>
			<th>Quantity </th>
			<th>Price </th>
			<th>Total </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9386";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9387";//Add
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
		$fields="pos_invoiceconsumables.id, inv_items.name as itemid, inv_unitofmeasures.name as unitofmeasureid, pos_invoiceconsumables.quantity, pos_invoiceconsumables.price, pos_invoiceconsumables.total, pos_invoiceconsumables.remarks, pos_invoiceconsumables.ipaddress, pos_invoiceconsumables.createdby, pos_invoiceconsumables.createdon, pos_invoiceconsumables.lasteditedby, pos_invoiceconsumables.lasteditedon";
		$join=" left join inv_items on pos_invoiceconsumables.itemid=inv_items.id  left join inv_unitofmeasures on pos_invoiceconsumables.unitofmeasureid=inv_unitofmeasures.id ";
		$having="";
		$groupby="";
		$orderby="";
		$invoiceconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$invoiceconsumables->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->unitofmeasureid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9386";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addinvoiceconsumables_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9387";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='invoiceconsumables.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
