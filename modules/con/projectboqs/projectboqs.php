<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectboqs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectboqs";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8520";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectboqs=new Projectboqs();
if(!empty($delid)){
	$projectboqs->id=$delid;
	$projectboqs->delete($projectboqs);
	redirect("projectboqs.php");
}
//Authorization.
$auth->roleid="8519";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprojectboqs_proc.php',600,430);" value="Add Projectboqs " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Bill Of Quantity </th>
			<th>BoQ Detail </th>
			<th>Quantity </th>
			<th>Unit Of Measure </th>
			<th>BQ Rate </th>
			<th>Total </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8521";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8522";//View
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
		$fields="con_projectboqs.id, tender_billofquantities.name as billofquantitieid, con_projectboqs.name, con_projectboqs.quantity, tender_unitofmeasures.name as unitofmeasureid, con_projectboqs.bqrate, con_projectboqs.total, con_projectboqs.remarks, con_projectboqs.ipaddress, con_projectboqs.createdby, con_projectboqs.createdon, con_projectboqs.lasteditedby, con_projectboqs.lasteditedon";
		$join=" left join tender_billofquantities on con_projectboqs.billofquantitieid=tender_billofquantities.id  left join tender_unitofmeasures on con_projectboqs.unitofmeasureid=tender_unitofmeasures.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectboqs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectboqs->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->billofquantitieid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->unitofmeasureid; ?></td>
			<td><?php echo formatNumber($row->bqrate); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8521";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectboqs_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8522";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectboqs.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
