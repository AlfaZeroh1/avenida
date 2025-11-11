<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Breederdeliverys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addbreederdeliverys_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Breederdeliverys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8564";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$breederdeliverys=new Breederdeliverys();
if(!empty($delid)){
	$breederdeliverys->id=$delid;
	$breederdeliverys->delete($breederdeliverys);
	redirect("breederdeliverys.php");
}
//Authorization.
$auth->roleid="8563";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a class="btn btn-info" href='addbreederdeliverys_proc.php'>New Breederdeliverys</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Delivery No </th>
			<th>Breeder </th>
			<th>Date Delivered </th>
			<th>Calendar Week </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8565";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8566";//View
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
		$fields="prod_breederdeliverys.id, prod_breederdeliverys.documentno, prod_breeders.name as breederid, prod_breederdeliverys.deliveredon, prod_breederdeliverys.week, prod_breederdeliverys.remarks, prod_breederdeliverys.ipaddress, prod_breederdeliverys.createdby, prod_breederdeliverys.createdon, prod_breederdeliverys.lasteditedby, prod_breederdeliverys.lasteditedon";
		$join=" left join prod_breeders on prod_breederdeliverys.breederid=prod_breeders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$breederdeliverys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$breederdeliverys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->breederid; ?></td>
			<td><?php echo formatDate($row->deliveredon); ?></td>
			<td><?php echo $row->week; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8565";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addbreederdeliverys_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8566";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='breederdeliverys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
