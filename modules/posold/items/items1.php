<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Items_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Items";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2161";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$items=new Items();
if(!empty($delid)){
	$items->id=$delid;
	$items->delete($items);
	redirect("items.php");
}
//Authorization.
$auth->roleid="2160";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('additems_proc.php',600,430);" value="Add Items " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Code </th>
			<th>Name </th>
			<th>Department </th>
			<th>Category </th>
			<th>Colour</th>
			<th>Price </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="2162";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2163";//View
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
		$fields="pos_items.id, pos_items.code, pos_items.name, pos_departments.name as departmentid, pos_categorys.name as categoryid, pos_items.price, pos_colours.name colourid, pos_items.tax, pos_items.stock, pos_itemstatuss.name as itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
		$join=" left join pos_departments on pos_items.departmentid=pos_departments.id  left join pos_categorys on pos_items.categoryid=pos_categorys.id  left join pos_itemstatuss on pos_items.itemstatusid=pos_itemstatuss.id left join pos_colours on pos_colours.id=pos_items.colourid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pos_items.itemstatusid=1 ";
		$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$items->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->colourid; ?></td>
			<td align="right"><?php echo formatNumber($row->price); ?></td>
			<td><a href="../itemvarietys/itemvarietys.php?id=<?php echo $row->id; ?>">Varieties</a></td>
			<td><a href="../../crm/customerprices/customerprices.php?customerid=<?php echo $row->id; ?>">Customer Prices</td>
			<td><a href="javascript:;" onclick="showPopWin('../itemstocks/itemstocks.php?itemid=<?php echo $row->id; ?>',1020,600);">Stock Card</a></td>
<?php
//Authorization.
$auth->roleid="2162";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('additems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2163";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='items.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
