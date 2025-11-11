<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimates_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Estimates";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11317";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$estimates=new Estimates();
if(!empty($delid)){
	$estimates->id=$delid;
	$estimates->delete($estimates);
	redirect("estimates.php");
}
//Authorization.
$auth->roleid="11316";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addestimates_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item Type </th>
			<th>Item Name </th>
<?php
//Authorization.
$auth->roleid="11318";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11319";//View
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
		$fields="bom_estimates.id, pos_itemss.name as itemid, pos_itemsdetails.name as itemdetailid, bom_estimates.createdby, bom_estimates.createdon, bom_estimates.lasteditedby, bom_estimates.lasteditedon, bom_estimates.ipaddress";
		$join=" left join pos_itemss on bom_estimates.itemid=pos_itemss.id  left join pos_itemsdetails on bom_estimates.itemdetailid=pos_itemsdetails.id ";
		$having="";
		$groupby="";
		$orderby="";
		$estimates->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$estimates->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->itemdetailid; ?></td>
<?php
//Authorization.
$auth->roleid="11318";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addestimates_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11319";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='estimates.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
