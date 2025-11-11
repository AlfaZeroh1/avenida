<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktakedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$ob = (object)$_GET;

$page_title="Stocktakedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11153";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$stocktakedetails=new Stocktakedetails();
if(!empty($delid)){
	$stocktakedetails->id=$delid;
	$stocktakedetails->delete($stocktakedetails);
	redirect("stocktakes.php");
}
//Authorization.
$auth->roleid="11152";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addstocktakedetails_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item Name </th>
			<th>Taken On </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Total </th>
<?php
//Authorization.
$auth->roleid="11154";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11155";//Add
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
		$fields="*";
		$join=" left join inv_items on inv_items.id=inv_stocktakedetails.itemid ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		if(!empty($ob->categoryid)){
		  $where.=" where inv_items.categoryid='$ob->categoryid' ";
		}
		$stocktakedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$stocktakedetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatDate($row->takenon); ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
<?php
//Authorization.
$auth->roleid="11154";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addstocktakedetails_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11155";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='stocktakes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
