<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemvarietys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Itemvarietys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8684";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";




$delid=$_GET['delid'];
$id=$_GET['id'];
$itemvarietys=new Itemvarietys();
if(!empty($delid)){
	$itemvarietys->id=$delid;
	$itemvarietys->delete($itemvarietys);
	redirect("itemvarietys.php");
}
//Authorization.
$auth->roleid="8683";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('additemvarietys_proc.php?itemid=<?php echo $id; ?>',600,430);" value="Add Itemvarietys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Product </th>
			<th>Variety </th>
			<th>Quantity </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8685";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8686";//Add
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
		$fields="pos_itemvarietys.id, pos_items.name as itemid, prod_varietys.name as varietyid, pos_itemvarietys.quantity, pos_itemvarietys.remarks, pos_itemvarietys.ipaddress, pos_itemvarietys.createdby, pos_itemvarietys.createdon, pos_itemvarietys.lasteditedby, pos_itemvarietys.lasteditedon";
		$join=" left join pos_items on pos_itemvarietys.itemid=pos_items.id  left join prod_varietys on pos_itemvarietys.varietyid=prod_varietys.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->id)){
		$where=" where pos_itemvarietys.itemid='$ob->id' ";
		}
		$itemvarietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$itemvarietys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8685";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('additemvarietys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8686";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='itemvarietys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
