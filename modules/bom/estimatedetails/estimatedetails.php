<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimatedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Estimatedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11313";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$estimatedetails=new Estimatedetails();
if(!empty($delid)){
	$estimatedetails->id=$delid;
	$estimatedetails->delete($estimatedetails);
	redirect("estimatedetails.php");
}
//Authorization.
$auth->roleid="11312";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addestimatedetails_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Estimate </th>
			<th>Item Name </th>
			<th>Quantity </th>
			<th>Units </th>
<?php
//Authorization.
$auth->roleid="11314";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11315";//Add
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
		$fields="bom_estimatedetails.id, pos_itemss.name as estimateid, inv_items.name as itemid, bom_estimatedetails.quantity, inv_unitofmeasures.name as unitid, bom_estimatedetails.createdby, bom_estimatedetails.createdon, bom_estimatedetails.lasteditedby, bom_estimatedetails.lasteditedon, bom_estimatedetails.ipaddress";
		$join=" left join bom_estimates on bom_estimatedetails.estimateid=bom_estimates.id  left join inv_items on bom_estimatedetails.itemid=inv_items.id  left join inv_unitofmeasures on bom_estimatedetails.unitid=inv_unitofmeasures.id left join pos_itemss on pos_itemss.id=bom_estimates.itemid ";
		$having="";
		$groupby="";
		$orderby="";
		$estimatedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$estimatedetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->estimateid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->unitid; ?></td>
<?php
//Authorization.
$auth->roleid="11314";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addestimatedetails_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11315";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='estimatedetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
