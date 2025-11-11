<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimationdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Estimationdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11365";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$estimationdetails=new Estimationdetails();
if(!empty($delid)){
	$estimationdetails->id=$delid;
	$estimationdetails->delete($estimationdetails);
	redirect("estimationdetails.php");
}
//Authorization.
$auth->roleid="11364";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addestimationdetails_proc.php?estimationid=<?php echo $ob->estimationid; ?>',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Estimation </th>
			<th>Item Name </th>
			<th>Quantity </th>
			<th>Types</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="11366";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11367";//Add
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
		$fields="bom_estimationdetails.id, bom_estimations.name as estimationid, bom_estimationdetails.type, inv_items.name as itemid, bom_estimationdetails.quantity, inv_unitofmeasures.name as unitofmeasureid, bom_estimationdetails.remarks, bom_estimationdetails.types,bom_estimationdetails.createdby, bom_estimationdetails.createdon, bom_estimationdetails.lasteditedby, bom_estimationdetails.lasteditedon, bom_estimationdetails.ipaddress";
		$join=" left join bom_estimations on bom_estimationdetails.estimationid=bom_estimations.id  left join inv_items on bom_estimationdetails.itemid=inv_items.id  left join inv_unitofmeasures on bom_estimationdetails.unitofmeasureid=inv_unitofmeasures.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		if(!empty($ob->estimationid)){
		  $where.=" where estimationid='$ob->estimationid' ";
		}
		$estimationdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$estimationdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->estimationid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->types; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="11366";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addestimationdetails_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11367";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='estimationdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
