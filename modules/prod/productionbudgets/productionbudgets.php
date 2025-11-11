<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Productionbudgets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Productionbudgets";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9294";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$productionbudgets=new Productionbudgets();
if(!empty($delid)){
	$productionbudgets->id=$delid;
	$productionbudgets->delete($productionbudgets);
	redirect("productionbudgets.php?greenhousevarietyid=".$ob->greenhousevarietyid);
}
//Authorization.
$auth->roleid="9293";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addproductionbudgets_proc.php?greenhousevarietyid=<?php echo $ob->greenhousevarietyid; ?>',600,430);" value="Add Productionbudgets " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Green House Variety </th>
			<th>Month </th>
			<th>Year </th>
			<th>Date Of Budget </th>
			<th>Quantity </th>
<?php
//Authorization.
$auth->roleid="9295";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9296";//Add
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
		$fields="prod_productionbudgets.id, concat(prod_greenhouses.name,' ',prod_varietys.name) as greenhousevarietyid, prod_greenhousevarietys.id ghvid, prod_productionbudgets.month, prod_productionbudgets.year, prod_productionbudgets.budgetedon, prod_productionbudgets.quantity, prod_productionbudgets.ipaddress, prod_productionbudgets.createdby, prod_productionbudgets.createdon, prod_productionbudgets.lasteditedby, prod_productionbudgets.lasteditedon";
		$join=" left join prod_greenhousevarietys on prod_productionbudgets.greenhousevarietyid=prod_greenhousevarietys.id left join prod_greenhouses on prod_greenhouses.id=prod_greenhousevarietys.greenhouseid left join prod_varietys on prod_varietys.id=prod_greenhousevarietys.varietyid ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->greenhousevarietyid))
		  $where=" where prod_greenhousevarietys.id='$ob->greenhousevarietyid'";
		$productionbudgets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$productionbudgets->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->greenhousevarietyid; ?></td>
			<td><?php echo getMonth($row->month); ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo formatDate($row->budgetedon); ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
<?php
//Authorization.
$auth->roleid="9295";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addproductionbudgets_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9296";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='productionbudgets.php?delid=<?php echo $row->id; ?>&greenhousevarietyid=<?php echo $row->ghvid; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
